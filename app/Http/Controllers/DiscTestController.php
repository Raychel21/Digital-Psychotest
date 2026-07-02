<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscQuestion;
use App\Models\Participant;
use App\Models\DiscAnswer;
use App\Models\Token;
use App\Services\DiscScoringService;

class DiscTestController extends Controller
{
    // ---------------------------------------------------------
    // TAHAP 1: TOKEN
    // ---------------------------------------------------------
    public function showTokenForm()
    {
        return view('disc-test.token');
    }

    public function verifyToken(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string', 'regex:/^\d{4}_[A-Z]{3}$/']
        ], [
            'token.regex' => 'Format token harus berupa 4 digit angka, underscore, dan 3 huruf kapital (contoh: 0001_ABC).'
        ]);

        $token = Token::where('code', $request->token)->first();

        if (!$token) {
            return back()->withErrors(['token' => 'Token tidak ditemukan.']);
        }

        if ($token->status === 'used') {
            return back()->withErrors(['token' => 'Token ini sudah digunakan.']);
        }

        // Simpan token ke session
        session(['valid_token' => $token->code]);

        return redirect()->route('disc-test.data-diri');
    }

    // ---------------------------------------------------------
    // TAHAP 2: DATA DIRI
    // ---------------------------------------------------------
    public function showDataDiriForm()
    {
        if (!session()->has('valid_token')) {
            return redirect()->route('disc-test.token')->withErrors(['token' => 'Silakan masukkan token terlebih dahulu.']);
        }
        return view('disc-test.data-diri');
    }

    public function storeDataDiri(Request $request)
    {
        if (!session()->has('valid_token')) {
            return redirect()->route('disc-test.token');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'pendidikan_terakhir' => 'required|string|max:255',
            'positions' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:20',
        ]);

        // Simpan data diri peserta langsung ke database agar mendapatkan ID
        $participant = Participant::create(array_merge($validated, [
            'token' => session('valid_token'),
            'started_at' => now(),
        ]));

        session(['participant_id' => $participant->id]);

        return redirect()->route('disc-test.instruksi');
    }

    // ---------------------------------------------------------
    // TAHAP 3: INSTRUKSI
    // ---------------------------------------------------------
    public function showInstruksi()
    {
        if (!session()->has('participant_id')) {
            return redirect()->route('disc-test.data-diri');
        }
        return view('disc-test.instruksi');
    }

    // ---------------------------------------------------------
    // TAHAP 4: PENGERJAAN TES
    // ---------------------------------------------------------
    public function showSoal()
    {
        if (!session()->has('participant_id')) {
            return redirect()->route('disc-test.data-diri');
        }
        
        $questions = DiscQuestion::with('items')->orderBy('nomor')->get();
        return view('disc-test.soal', compact('questions'));
    }

    public function storeSoal(Request $request)
    {
        if (!session()->has('participant_id')) {
            return redirect()->route('disc-test.data-diri');
        }

        $request->validate([
            'most' => 'required|array|size:24',
            'least' => 'required|array|size:24',
        ], [
            'most.size' => 'Anda harus mengisi pilihan Paling Menggambarkan pada semua 24 soal.',
            'least.size' => 'Anda harus mengisi pilihan Kurang Menggambarkan pada semua 24 soal.'
        ]);

        $participantId = session('participant_id');
        $tokenCode = session('valid_token');

        // Simpan jawaban
        foreach ($request->most as $questionId => $mostItemId) {
            $leastItemId = $request->least[$questionId] ?? null;
            if ($leastItemId) {
                DiscAnswer::create([
                    'participant_id' => $participantId,
                    'disc_question_id' => $questionId,
                    'most_item_id' => $mostItemId,
                    'least_item_id' => $leastItemId,
                ]);
            }
        }

        // Update waktu selesai
        $participant = Participant::findOrFail($participantId);
        $participant->update(['completed_at' => now()]);

        // Update token menjadi used
        $token = Token::where('code', $tokenCode)->first();
        if ($token) {
            $token->update([
                'status' => 'used',
                'participant_id' => $participantId
            ]);
        }

        // Hapus session agar tidak bisa di-replay
        session()->forget(['valid_token', 'participant_id']);

        return redirect()->route('disc-test.result', $participantId)
            ->with('success', 'Tes DISC berhasil diselesaikan.');
    }

    // ---------------------------------------------------------
    // HASIL (Tetap seperti sebelumnya)
    // ---------------------------------------------------------
    public function result($id, DiscScoringService $scoringService)
    {
        $participant = Participant::findOrFail($id);
        $rawScores = $scoringService->calculateRawScores($id);
        $normScores = $scoringService->convertRawToNorm($rawScores);

        $graph3 = $normScores['graph_3'];
        $highestDimension = array_keys($graph3, max($graph3))[0];
        
        $graph1 = $normScores['graph_1'];
        $highestDimensionGraph1 = array_keys($graph1, max($graph1))[0];
        
        $personalityLabels = [
            'D' => 'Dominance (Dominan, Tegas, Pengambil Risiko)',
            'I' => 'Influence (Berpengaruh, Antusias, Ramah)',
            'S' => 'Steadiness (Stabil, Sabar, Pendengar Baik)',
            'C' => 'Conscientiousness (Teliti, Analitis, Taat Aturan)'
        ];
        $primaryPersonality = $personalityLabels[$highestDimension] ?? 'Unknown';
        $graph1Personality = $personalityLabels[$highestDimensionGraph1] ?? 'Unknown';

        $interpretations = [
            'D' => 'Memiliki dorongan kuat untuk mengontrol lingkungan dan mencapai hasil. Sangat mandiri, berorientasi pada target, dan tidak ragu mengambil tantangan. Terkadang bisa terlihat terlalu menuntut atau agresif.',
            'I' => 'Suka bersosialisasi, persuasif, dan sangat optimis. Cenderung menjadi pusat perhatian dan pandai memotivasi orang lain. Terkadang kurang fokus pada detail dan lebih mengandalkan emosi/intuisi.',
            'S' => 'Tenang, sabar, dan sangat menghargai harmoni. Merupakan pendengar yang baik dan anggota tim yang dapat diandalkan. Terkadang kurang menyukai perubahan mendadak atau konflik terbuka.',
            'C' => 'Sangat teliti, analitis, dan berorientasi pada standar tinggi. Selalu memastikan akurasi dan kualitas kerja. Terkadang terlalu perfeksionis dan terlalu banyak menganalisis sebelum bertindak.'
        ];
        $graph1Interpretation = $interpretations[$highestDimensionGraph1] ?? '';

        return view('disc-test.result', compact('participant', 'rawScores', 'normScores', 'primaryPersonality', 'graph1Personality', 'graph1Interpretation', 'personalityLabels', 'interpretations'));
    }
}
