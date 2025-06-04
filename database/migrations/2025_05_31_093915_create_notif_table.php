        <?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        return new class extends Migration
        {
            public function up()
            {
                Schema::create('notifications', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('user_id');
                    $table->string('title');
                    $table->text('message');
                    $table->enum('type', [
                        'peminjaman_approved', 
                        'peminjaman_rejected', 
                        'pengembalian_reminder', 
                        'pengembalian_overdue',
                        'pengembalian_approved'
                    ]);
                    $table->boolean('is_read')->default(false);
                    $table->timestamps();
                    
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

                    $table->index(['user_id', 'is_read']);
                });
            }

            public function down()
            {
                Schema::dropIfExists('notifications');
            }
        };
