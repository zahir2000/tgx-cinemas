<?php

/**
 * Here lies Movie class
 *
 * @author Jaloliddin
 */
class Movie {

    private $movieID;
    private $name; //string
    private $poster; //string
    private $length; //integer
    private $status; //string
    private $genre; //string
    private $language; //string
    private $subtitle; //string
    private $ageRestriction; //string
    private $releaseDate; //Date
    private $cast; //string
    private $director; //string
    private $distributor; //string
    private $synopsis; //string
    private Admin $admin;

    function __construct($movieID = "", $name = "", $poster = "", $length = 0, $status = "", $genre = "", $language = "", $subtitle = "",
            $ageRestriction = "", $releaseDate = "", $cast = "", $director = "", $distributor = "", $synopsis = "", Admin $admin = NULL) {
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
        $this->admin = $admin;
    }

    function getMovieID() {
        return $this->movieID;
    }

    function getName() {
        return $this->name;
    }

    function getPoster() {
        return $this->poster;
    }

    function getLength() {
        return $this->length;
    }

    function getStatus() {
        return $this->status;
    }

    function getGenre() {
        return $this->genre;
    }

    function getLanguage() {
        return $this->language;
    }

    function getSubtitle() {
        return $this->subtitle;
    }

    function getAgeRestriction() {
        return $this->ageRestriction;
    }

    function getReleaseDate() {
        return $this->releaseDate;
    }

    function getCast() {
        return $this->cast;
    }

    function getDirector() {
        return $this->director;
    }

    function getDistributor() {
        return $this->distributor;
    }

    function getSynopsis() {
        return $this->synopsis;
    }

    function setMovieID($movieID): void {
        $this->movieID = $movieID;
    }

    function setName($name): void {
        $this->name = $name;
    }

    function setPoster($poster): void {
        $this->poster = $poster;
    }

    function setLength($length): void {
        $this->length = $length;
    }

    function setStatus($status): void {
        $this->status = $status;
    }

    function setGenre($genre): void {
        $this->genre = $genre;
    }

    function setLanguage($language): void {
        $this->language = $language;
    }

    function setSubtitle($subtitle): void {
        $this->subtitle = $subtitle;
    }

    function setAgeRestriction($ageRestriction): void {
        $this->ageRestriction = $ageRestriction;
    }

    function setReleaseDate($releaseDate): void {
        $this->releaseDate = $releaseDate;
    }

    function setCast($cast): void {
        $this->cast = $cast;
    }

    function setDirector($director): void {
        $this->director = $director;
    }

    function setDistributor($distributor): void {
        $this->distributor = $distributor;
    }

    function setSynopsis($synopsis): void {
        $this->synopsis = $synopsis;
    }

    function getAdmin(): Admin {
        return $this->admin;
    }

    function setAdmin(Admin $admin): void {
        $this->admin = $admin;
    }

}
