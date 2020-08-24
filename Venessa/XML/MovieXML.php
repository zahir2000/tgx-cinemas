<?php

require_once 'MovieXPath.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Venessa/FactoryMethod/FileLoggerFactory.php';

/**
 * Description of MovieXML
 *
 * @author: Venessa Choo Wei Ling
 */
class MovieXML {

    private $xmlFilePath = "XML/Movies.xml";
    private $xslFilePath = "XML/Movies.xsl";
    private $xpath = null;
    private $loggerFactory = null;
    private $logger = null;

    public function __construct() {
        $this->xpath = new MovieXPath($this->xmlFilePath);

        $this->loggerFactory = new FileLoggerFactory();
        $this->logger = $this->loggerFactory->createLogger();
    }

    function createXMLFile($movieList) {
        $this->logger->log("Creating Movie.xml in " . $this->xmlFilePath);
        $dom = new DOMDocument('1.0', 'utf-8');
        $dom->formatOutput = true;

        try {
            $root = $this->createXMLElement($dom, $movieList);

            $dom->appendChild($root);
            $dom->save($this->xmlFilePath);
            $this->logger->log("Done creating Movie.xml in " . $this->xmlFilePath);
        } catch (Exception $ex) {
            $this->logger->log("Fail creating Movie.xml: " . $ex->getMessage());
        }
    }

    private function createXMLElement($dom, $movieList) {
        $root = $dom->createElement('movies');

        try {
            foreach ($movieList as $m) {
                $id = $m['movieID'];
                $name = $m['name'];
                $poster = $m['poster'];
                $length = $m['length'];
                $status = $m['status'];
                $genre = $m['genre'];
                $language = $m['language'];
                $subtitle = $m['subtitle'];
                $ageRestriction = $m['ageRestriction'];
                $releaseDate = $m['releaseDate'];
                $cast = $m['cast'];
                $director = $m['director'];
                $distributor = $m['distributor'];
                $synopsis = $m['synopsis'];

                $movie = $dom->createElement('movie');
                $movie->setAttribute('movieID', $id);

                $movieID = $dom->createElement('movieID', htmlspecialchars($id));
                $movie->appendChild($movieID);
                $movieName = $dom->createElement('name', htmlspecialchars($name));
                $movie->appendChild($movieName);
                $moviePoster = $dom->createElement('poster', htmlspecialchars($poster));
                $movie->appendChild($moviePoster);
                $movieLength = $dom->createElement('length', htmlspecialchars($length));
                $movie->appendChild($movieLength);
                $movieStatus = $dom->createElement('status', htmlspecialchars($status));
                $movie->appendChild($movieStatus);
                $movieGenre = $dom->createElement('genre', htmlspecialchars($genre));
                $movie->appendChild($movieGenre);
                $movieLanguage = $dom->createElement('language', htmlspecialchars($language));
                $movie->appendChild($movieLanguage);
                $movieSubtitle = $dom->createElement('subtitle', htmlspecialchars($subtitle));
                $movie->appendChild($movieSubtitle);
                $movieAgeRestriction = $dom->createElement('ageRestriction', htmlspecialchars($ageRestriction));
                $movie->appendChild($movieAgeRestriction);
                $movieReleaseDate = $dom->createElement('releaseDate', htmlspecialchars($releaseDate));
                $movie->appendChild($movieReleaseDate);
                $movieCast = $dom->createElement('cast', htmlspecialchars($cast));
                $movie->appendChild($movieCast);
                $movieDirector = $dom->createElement('director', htmlspecialchars($director));
                $movie->appendChild($movieDirector);
                $movieDistributor = $dom->createElement('distributor', htmlspecialchars($distributor));
                $movie->appendChild($movieDistributor);
                $movieSynopsis = $dom->createElement('synopsis', htmlspecialchars($synopsis));
                $movie->appendChild($movieSynopsis);

                $root->appendChild($movie);
            }

            return $root;
        } catch (Exception $ex) {
            $this->logger->log("Error creating Movie.xml: " . $ex->getMessage());
            return null;
        }
    }

    function readFromXML() {
        $this->logger->log("Read from Movie.xml");
        $xmlFile = new DOMDocument();
        try {
            $xmlFile->load($this->xmlFilePath);
        } catch (Exception $ex) {
            echo $this->xmlFilePath . ' not found';
            $this->logger->log("Fail to read Movie.xml: " . $ex->getMessage());
            return;
        }

        $xslFile = new DOMDocument();
        try {
            $xslFile->load($this->xslFilePath);
        } catch (Exception $ex) {
            echo $this->xmlFilePath . ' not found';
            $this->logger->log("Fail to read Movie.xsl: " . $ex->getMessage());
            return;
        }

        $proc = new XSLTProcessor();
        $proc->registerPHPFunctions();
        $proc->importStyleSheet($xslFile);

        echo $proc->transformToXML($xmlFile);
    }

    function checkXMLByID($movieID) {
        $this->xpath->checkID($movieID);
    }

    function readFromXMLByID($movieID) {
        $this->xpath->getMovieDetailById($movieID);
    }

}
