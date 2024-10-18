<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameQuantityToTicketNumberInTicketsTable extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->renameColumn('quantity', 'ticket_number');
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->renameColumn('ticket_number', 'quantity');
        });
    }
}
