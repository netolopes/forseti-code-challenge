<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\DomCrawler\Crawler;

class NoticiasController extends Controller
{

    public function index(){

        $page = (isset($_GET['page'])) ? $_GET['page'] : '0';

        $urlPrincipal="https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias?b_start:int=".$page;

        $httpClient = new \GuzzleHttp\Client();
        $response = $httpClient->get($urlPrincipal);
        $htmlString = (string) $response->getBody();
        libxml_use_internal_errors(true);

        $crawler = new Crawler();
        $crawler->addHtmlContent($htmlString);

        $titulos = $crawler->filterXPath("//*[contains(@class, 'tileHeadline')]")->extract(['_text']);
        $dtHr = $crawler->filterXPath("//*[contains(@class, 'summary-view-icon')]")->extract(['_text']);
        $links = $crawler->filter('.tileHeadline a')->extract(['href']);


        $arrHrs = [];
        $arrDts = [];
        foreach ($dtHr as $key => $val) {

          if(trim($val) != 'Notícias'){
            if (strpos($val, 'h') !== false) {
                $arrHrs[] = $val;
            }else{
                $arrDts[] = $val;
            }
          }

        }

        return view('news.news',compact('titulos','arrHrs','arrDts','links'));
    }


    public function details(Request $request){

            $url = (isset($_GET['link'])) ? $_GET['link'] : '';

            $urlPrincipal=$url;

            $httpClient = new \GuzzleHttp\Client();
            $response = $httpClient->get($urlPrincipal);
            $htmlString = (string) $response->getBody();
            libxml_use_internal_errors(true);

            $crawler = new Crawler();
            $crawler->addHtmlContent($htmlString);

            $data = $crawler->filterXPath("//*[contains(@id, 'parent-fieldname-text')]")->extract(['_text']);

            return view('news.details',compact('data'));
    }

    public function saveData(){

        try {

            $pg = 0;
            for ($i=0; $i < 5; $i++) {
                if($i == 1){
                    $pg = 30;
                }else if($i == 2){
                    $pg = 60;
                }else if($i == 3){
                    $pg = 90;
                }else if($i == 4){
                    $pg = 120;
                }

                $urlPrincipal="https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias?b_start:int=".$pg;

                $httpClient = new \GuzzleHttp\Client();
                $response = $httpClient->get($urlPrincipal);
                $htmlString = (string) $response->getBody();
                libxml_use_internal_errors(true);

                $crawler = new Crawler();
                $crawler->addHtmlContent($htmlString);

                $titulos = $crawler->filterXPath("//*[contains(@class, 'tileHeadline')]")->extract(['_text']);
                $dtHr = $crawler->filterXPath("//*[contains(@class, 'summary-view-icon')]")->extract(['_text']);
                $links = $crawler->filter('.tileHeadline a')->extract(['href']);


                $arrHrs = [];
                $arrDts = [];
                foreach ($dtHr as $key => $val) {

                if(trim($val) != 'Notícias'){
                    if (strpos($val, 'h') !== false) {
                        $arrHrs[] = $val;
                    }else{
                        $arrDts[] = $val;
                    }
                }
                }

                foreach ($titulos as $key => $value){
                    $noticia = new Noticia();
                    $noticia->nome = trim($value);
                    $noticia->hra = trim($arrHrs[$key]);
                    $noticia->dta = trim($arrDts[$key]);
                    $noticia->link = trim($links[$key]);
                    $noticia->validacao = md5(trim($noticia->link));
                    $result = $noticia->save();
                }
            }

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Dados duplicados - Integrity constraint violation: 1062 Duplicate entry for key noticias_validacao_unique');
        }

        if ($result){
            return redirect()->back()->with('success', 'Dados salvos com sucesso!');
        }
    }
}



