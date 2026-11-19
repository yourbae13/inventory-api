<?php 
  
use Illuminate\Database\Migrations\Migration; 
 use Illuminate\Database\Schema\Blueprint; 
 use Illuminate\Support\Facades\DB; 
 use Illuminate\Support\Facades\Schema; 
  
return new class extends Migration { 
     public function up(): void 
     { 
         Schema::create('products', function (Blueprint $table) { 
             $table->id(); 
             $table->string('name', 100); 
             $table->integer('price'); 
             $table->integer('stock'); 
             $table->timestamps(); 
         }); 
  
        DB::statement('ALTER TABLE products ENABLE ROW LEVEL SECURITY'); 
     } 
  
    public function down(): void 
     { 
         Schema::dropIfExists('products'); 
     } 
 }; 