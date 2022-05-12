<?php

namespace Tests\Feature;

use App\Models\Noticia;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsTest extends TestCase
{
    //resolve error quotation
    use DatabaseMigrations;

    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_show_news()
    {
        $response = $this->getJson('/api/noticias');

        $response->assertStatus(200);
    }

    public function test_show_details_news()
    {
        $link = 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias/manutencao-no-sistema-compras-gov.br';
        $response =  $this->call('GET', '/details', ["link"=>$link]);

        $response->assertStatus(200);
    }

    public function test_save_news()
    {
        $news = Noticia::factory()->create();
        $response = $this->get('/save', [
            'nome'=> $news->nome,
            'dta'=> $news->dta,
            'hra'=> $news->hra,
            'link'=> $news->link,
            'validacao'=> $news->validacao
        ]);
        //if true else redirect page
        $response->assertStatus(302);
    }
}
