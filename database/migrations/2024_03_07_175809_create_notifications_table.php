<?php

use App\Base\Enums\NotificationChannel;
use App\Base\Models\Notifiable;
use App\Base\Models\Notification;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Notification::getTableName(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('channel_name', NotificationChannel::casesValues())->default(NotificationChannel::FIREBASE->value);
            $table->string('title');
            $table->string('content');
            $table->string('image')->nullable();
            $table->date('read_at')->nullable();
            $table->string('notifiable_type');
            $table->unsignedBigInteger('notifiable_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Notification::getTableName());
    }
};
