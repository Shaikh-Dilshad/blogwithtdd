<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Blog;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\Factory; // Import the Factory class


class BlogTest extends TestCase
{
    use DatabaseTransactions;
    
    
    // public function setUp()
    // {
    //     parent::setUp();
    //     factory(Blog::class)->create([
            
    //         'id' => 1,
    //         'title'=>'dilshad',
    //         'description' => 'description',
    //         'image'=>'123.jpg'
    //     ]);

    // }
    
    /**
     * @test
     */
    public function checking_getting_store_or_not(){
        Session::start(); 
        Storage::fake('public');
        $image = UploadedFile::fake()->image('blog-image.jpg');
        $payload = [
            'id'=>1,
            'title'=>'dilshad',
            'description'=>'description',
            'image'=>$image,
        ];
        $response = $this->json('post', route('blogs.store'), $payload,[
            'X-CSRF-TOKEN' => csrf_token()])
            ->assertStatus(201);        
        // dd( $response );
    }

   

     /**
     * @test
     */
    public function checking_data_updated_or_not(){
        Session::start(); 
       Blog::create([
        'id'=>1,
          'title'=>'dilshad',
          'description'=>'description'
       ]);
       $forupdate = [
          'id'=>1,
          'title'=>'dilshad',
          'description'=>'description'
       ];
       $response = $this->json('PUT',route('blogs.update',['id'=>1]),$forupdate,['X-CSRF-TOKEN' => csrf_token()])
       ->assertStatus(201);
    //    dd($response->getContent());
        
       
    
    }
    
    /**
     * @test
     */
    public function list_of_blogs_added(){
        
        $response = $this->json('GET', route('blogs.list'),[
         'X-CSRF-TOKEN' => csrf_token()])
             ->assertStatus(200);
     }
     /**
      * @test
      */
    public function list_deleted_or_not(){
        Blog::create([
            'id'=>1,
              'title'=>'dilshad',
              'description'=>'description'
           ]);
        $response = $this->json('get', route('blogs.destroy',['id'=>1]),[
            'X-CSRF-TOKEN' => csrf_token()])
            ->assertStatus(204);

       $this->assertCount(0 , Blog::all());
    }
}
