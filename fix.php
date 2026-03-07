<?php
$user = App\Models\User::where('name', 'like', '%chanyeol%')->first();
if ($user && $user->referred_by) {
    echo "User found. Referrer ID: " . $user->referred_by . "\n";
    $alreadyGiven = \App\Models\PointLedger::where('user_id', $user->referred_by)
        ->where('description', 'like', '%' . $user->name . '%')
        ->where('amount', 50)
        ->exists();
        
    if (!$alreadyGiven) {
        $referrer = App\Models\User::find($user->referred_by);
        if ($referrer) {
            \App\Models\PointLedger::create([
                'user_id' => $referrer->id,
                'amount' => 50,
                'type' => 'credit',
                'description' => 'Komisi pendaftaran Layanan SALUT mahasiswa: ' . $user->name,
            ]);
            // Removed erroneous increment call
            echo "Points retrospectively given to " . $referrer->name . "\n";
        }
    } else {
        echo "Points already given to referrer.\n";
    }
} else {
    echo "User or referrer not found.\n";
}
