<?php

namespace App\Filament\Participant\Widgets;

use App\Actions\Participant\RedeemInvitation;
use App\Filament\Participant\Pages\TakeTest;
use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Validation\ValidationException;

class RedeemInvitationWidget extends Widget
{
    protected string $view = 'filament.participant.widgets.redeem-invitation-widget';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    public string $code = '';

    /**
     * Tukarkan kode undangan lalu arahkan ke halaman pengerjaan tes.
     *
     * @throws ValidationException error tampil di bawah input kode.
     */
    public function redeem(RedeemInvitation $redeemInvitation): void
    {
        if (trim($this->code) === '') {
            throw ValidationException::withMessages([
                'code' => 'Masukkan kode undangan terlebih dahulu.',
            ]);
        }

        /** @var User $user */
        $user = auth()->user();

        $attempt = $redeemInvitation->handle($user, $this->code);

        $this->redirect(TakeTest::getUrl(['attempt' => $attempt]));
    }
}
