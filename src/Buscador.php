<?php 

namespace Alura\BuscadorDeCursos;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{

    private $httpClient;
    private $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array
    {

        $response = $this->httpClient->request('GET', $url);
        $html = $response->getBody()->getContents();
        
        $this->crawler->addHtmlContent($html);
        
        $elementosCursos = $this->crawler->filter('li.subcategoria__item');
        $cursos = [];
        foreach ($elementosCursos as $elemento) {
            $cursos[] = $elemento->textContent;
        }
        return $cursos;
    }
}
