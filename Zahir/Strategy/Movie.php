<?php

/**
 * Description of Movie
 *
 * @author Zahir
 */
class Movie {

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

    function __construct($name = "", $poster = "", $length = "", $status = "",
            $genre = "", $language = "", $subtitle = "", $ageRestriction = "",
            $releaseDate = "", $cast = "", $director = "", $distributor = "", $synopsis = "") {
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

}
