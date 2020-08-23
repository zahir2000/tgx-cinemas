<?php

require_once 'MovieInterface.php';

/**
 * Description of Movie
 *
 * @author Venessa Choo Wei Ling
 */
class Movie implements MovieInterface {

    private $movieID;
    private $name;
    private $poster;
    private $length;
    private $status;
    private $genre;
    private $language;
    private $subtitle;
    private $ageRestriction;
    private $releaseDate;
    private $cast;
    private $director;
    private $distributor;
    private $synopsis;

    public function __construct($movieID, $name, $poster, $length, $status, $genre, $language, $subtitle, $ageRestriction, $releaseDate, $cast, $director, $distributor, $synopsis) {
        $this->movieID = $movieID;
        $this->name = $name;
        $this->poster = $poster;
        $this->length = $length;
        $this->status = $status;
        $this->genre = $genre;
        $this->language = $language;
        $this->subtitle = $subtitle;
        $this->ageRestriction = $ageRestriction;
        $this->releaseDate = $releaseDate;
        $this->cast = $cast;
        $this->director = $director;
        $this->distributor = $distributor;
        $this->synopsis = $synopsis;
    }

    public function getMovieID() {
        return $this->movieID;
    }

    public function getName() {
        return $this->name;
    }

    public function getPoster() {
        return $this->poster;
    }

    public function getLength() {
        return $this->length;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getGenre() {
        return $this->genre;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function getSubtitle() {
        return $this->subtitle;
    }

    public function getAgeRestriction() {
        return $this->ageRestriction;
    }

    public function getReleaseDate() {
        return $this->releaseDate;
    }

    public function getCast() {
        return $this->cast;
    }

    public function getDirector() {
        return $this->director;
    }

    public function getDistributor() {
        return $this->distributor;
    }

    public function getSynopsis() {
        return $this->synopsis;
    }

    public function setMovieID($movieID): void {
        $this->movieID = $movieID;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setPoster($poster): void {
        $this->poster = $poster;
    }

    public function setLength($length): void {
        $this->length = $length;
    }

    public function setStatus($status): void {
        $this->status = $status;
    }

    public function setGenre($genre): void {
        $this->genre = $genre;
    }

    public function setLanguage($language): void {
        $this->language = $language;
    }

    public function setSubtitle($subtitle): void {
        $this->subtitle = $subtitle;
    }

    public function setAgeRestriction($ageRestriction): void {
        $this->ageRestriction = $ageRestriction;
    }

    public function setReleaseDate($releaseDate): void {
        $this->releaseDate = $releaseDate;
    }

    public function setCast($cast): void {
        $this->cast = $cast;
    }

    public function setDirector($director): void {
        $this->director = $director;
    }

    public function setDistributor($distributor): void {
        $this->distributor = $distributor;
    }

    public function setSynopsis($synopsis): void {
        $this->synopsis = $synopsis;
    }

    public function toString() {
        return 'ID: ' . $this->getMovieID() .
                ', Name: ' . $this->getName() .
                ', Poster: ' . $this->getPoster() .
                ', Length: ' . $this->getLength() .
                ', Status: ' . $this->getStatus() .
                ', Genre: ' . $this->getGenre() .
                ', Language: ' . $this->getLanguage() .
                ', Subtitle: ' . $this->getSubtitle() .
                ', Age Restriction: ' . $this->getAgeRestriction() .
                ', Release Date: ' . $this->getReleaseDate() .
                ', Cast: ' . $this->getCast() .
                ', Director: ' . $this->getDirector() .
                ', Distributor: ' . $this->getDistributor() .
                ', Synopsis: ' . $this->getSynopsis();
    }

}
