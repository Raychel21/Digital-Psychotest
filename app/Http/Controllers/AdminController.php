<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token;
use App\Models\Participant;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_tokens' => Token::count(),
            'available_tokens' => Token::where('status', 'available')->count(),
            'used_tokens' => Token::where('status', 'used')->count(),
            'total_participants' => Participant::whereNotNull('completed_at')->count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function tokens()
    {
        $tokens = Token::orderBy('id', 'desc')->get();
        return view('admin.tokens', compact('tokens'));
    }

    public function generateTokens(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1|max:500',
            'test_type' => 'required|string|in:DiSC',
        ]);

        $amount = $request->amount;
        $testType = $request->test_type;

        // Generate a unique suffix for this batch
        do {
            $suffix = strtoupper(Str::random(3));
        } while (Token::where('code', 'like', '%_' . $suffix)->exists());

        $newTokens = [];
        for ($i = 1; $i <= $amount; $i++) {
            $prefix = str_pad($i, 4, '0', STR_PAD_LEFT);
            $code = "{$prefix}_{$suffix}";

            $newTokens[] = [
                'code' => $code,
                'test_type' => strtolower($testType),
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Token::insert($newTokens);

        return redirect()->back()->with('success', "$amount token berhasil di-generate dengan akhiran _$suffix.");
    }

    public function participants()
    {
        $participants = Participant::whereNotNull('completed_at')->orderBy('completed_at', 'desc')->get();
        return view('admin.participants', compact('participants'));
    }

    public function showParticipant($id, \App\Services\DiscScoringService $scoringService)
    {
        $participant = Participant::with(['answers.question', 'answers.mostItem', 'answers.leastItem'])->findOrFail($id);
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

        return view('admin.participant-detail', compact('participant', 'rawScores', 'normScores', 'primaryPersonality', 'graph1Personality', 'graph1Interpretation'));
    }
}
