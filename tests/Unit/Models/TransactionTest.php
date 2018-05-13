<?php

namespace Tests\Unit\Models;

use App\User;
use Tests\TestCase;
use App\Transaction;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TransactionTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_transaction_has_name_link_method()
    {
        $transaction = factory(Transaction::class)->create();

        $this->assertEquals(
            link_to_route('transactions.show', $transaction->name, [$transaction], [
                'title' => trans(
                    'app.show_detail_title',
                    ['name' => $transaction->name, 'type' => trans('transaction.transaction')]
                ),
            ]), $transaction->nameLink()
        );
    }

    /** @test */
    public function a_transaction_has_belongs_to_creator_relation()
    {
        $transaction = factory(Transaction::class)->make();

        $this->assertInstanceOf(User::class, $transaction->creator);
        $this->assertEquals($transaction->creator_id, $transaction->creator->id);
    }

    /** @test */
    public function a_transaction_has_type_attribute()
    {
        $transaction = factory(Transaction::class)->make(['in_out' => 1]);
        $this->assertEquals(__('transaction.income'), $transaction->type);

        $transaction->in_out = 0;
        $this->assertEquals(__('transaction.spending'), $transaction->type);
    }
}