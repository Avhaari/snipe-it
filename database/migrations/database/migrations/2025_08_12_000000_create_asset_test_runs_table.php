// database/migrations/2025_08_12_000000_create_asset_test_runs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetTestRunsTable extends Migration
{
    public function up()
    {
        Schema::create('asset_test_runs', function (Blueprint $table) {
            $table->increments('id');  // Auto-incrementing UNSIGNED INT PK:contentReference[oaicite:0]{index=0}
            $table->unsignedInteger('asset_id');
            $table->unsignedInteger('user_id');
            $table->string('test_type', 191)->nullable();  
            $table->enum('status', ['in_progress', 'completed'])->default('in_progress');  // Status of the test run:contentReference[oaicite:1]{index=1}
            $table->string('os_version', 191)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();  // Laravel created_at and updated_at
            // Define foreign keys with proper constraints
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_test_runs');
    }
}
