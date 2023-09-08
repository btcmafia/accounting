<?php

declare(strict_types=1);

namespace Scottlaurent\Accounting\ModelTraits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Scottlaurent\Accounting\Exceptions\JournalAlreadyExists;
use Scottlaurent\Accounting\Models\Journal;
use Scottlaurent\Accounting\Models\Ledger;

trait AccountingJournal
{

    public function journals(): MorphMany
    {
        return $this->morphMany(\App\Models\AccountingJournal::class, 'morphed');
    }


    public function journal(): MorphOne
    {
        return $this->morphOne(Journal::class, 'morphed');
    }

    /**
     * Initialize a journal for a given model object
     *
     * @param null|string $currency_code
     * @param null|string $ledger_id
     * @return mixed
     * @throws JournalAlreadyExists
     */
    public function initJournal(?string $currency_code = 'USD', ?string $ledger_id = null)
    {
        if (!$this->journal) {
            $journal = new Journal();
            $journal->ledger_id = $ledger_id;
            $journal->currency = $currency_code;
            $journal->balance = 0;
            return $this->journal()->save($journal);
        }
        throw new JournalAlreadyExists;
    }

    public function getLedgerByType($type)
    {
        return Ledger::where(['type' => $type])->firstOrFail();
    }

}
