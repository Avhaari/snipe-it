// database/migrations/2025_08_12_000001_create_asset_test_items_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetTestItemsTable extends Migration
{
    public function up()
    {
        Schema::create('asset_test_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('asset_test_run_id');
            $table->string('component', 191);  
            $table->enum('status', ['pass', 'fail', 'na'])->default('na');  // pass/fail/not-applicable
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            // Foreign key linking to the test run, cascade on delete
            $table->foreign('asset_test_run_id')->references('id')->on('asset_test_runs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_test_items');
    }
}
