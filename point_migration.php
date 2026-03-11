<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach(\App\Models\Withdrawal::all() as $w) {
    if($w->amount < 1000) {
        $w->update(['amount' => $w->amount * 1000]);
    }
}
echo "Migration withdrawal amount to rupiah scale complete.\n";
