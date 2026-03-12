<?php
$p = App\Models\PointLedger::where('description', 'like', '%chanyeol%')->first();
if ($p) {
    $p->source_id = 19;
    $p->save();
    echo "Updated source_id for ledger ID {$p->id} to 19.\n";
} else {
    echo "Not found.\n";
}
