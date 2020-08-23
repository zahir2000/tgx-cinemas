<?xml version="1.0" encoding="UTF-8"?>

<!--
    Document   : Showtime.xsl
    Created on : August 14, 2020, 11:18 PM
    Author     : Zahiriddin Rustamov
    Description: Display movie details based on showtimeId.
-->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/> 
    <xsl:template match="/">
        <html>
            <link rel="stylesheet" type="text/css" href="Showtime.css"/>
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" crossorigin="anonymous"/>
            
            <body>
                <div class="movie-details-panel">
                    <div class="movie-details-top">
                        <div class="movie-details-section movie-details-title">
                            <h1>Booking Details</h1>
                        </div>
                        <div class="movie-details-section movie-details-close" onclick="window.history.go(-1); return false;">
                            <i class="fas fa-2x fa-times"></i>
                        </div>
                    </div>
                    <div class="movie-details">
                        <xsl:for-each select="//showtime[@id=$showtimeID]">
                            <h3>
                                <xsl:value-of select='movie/name' />
                                <xsl:choose>
                                    <xsl:when test="movie/ageRestriction = '13'">
                                        <img src='../img/P13.png' alt='PG13 Rating' />
                                    </xsl:when>
                                    <xsl:when test="movie/ageRestriction = '18'">
                                        <img src='../img/P18.png' alt='PG18 Rating' />
                                    </xsl:when>
                                    <xsl:otherwise>
                                        <img src='../img/PU.png' alt='PGU Rating' />
                                    </xsl:otherwise>
                                </xsl:choose>
                            </h3>
                            
                            <div class="movie-details-content">
                                <span>
                                    <i class="fas fa-2x fa-map-marker-alt"></i>
                                    <xsl:value-of select='cinema/name' />
                                </span>
                            
                                <span>
                                    <i class="fas fa-2x fa-glasses"></i>
                                    <xsl:for-each select="cinema/hall/experience">
                                        <span style="padding-right:0.5vh"><xsl:value-of select='.' /></span>
                                    </xsl:for-each>
                                    
                                </span>
                            
                                <span>
                                    <img src='../img/screen-black.png' alt='Hall Screen' />
                                    <xsl:value-of select='cinema/hall/@id' />
                                </span>
                            
                                <span>
                                    <i class="far fa-2x fa-calendar-alt"></i>
                                    <xsl:value-of select="concat(substring(date, 9, 2),'-',substring(date, 6, 2),'-', substring(date, 1, 4))" />
                                </span>
                            
                                <span>
                                    <i class="far fa-2x fa-clock"></i>
                                    <xsl:value-of select='time' />
                                </span>
                                
                                <span>
                                    <xsl:choose>
                                        <xsl:when test="//seats">
                                            <i class="fas fa-2x fa-couch"></i>
                                            <xsl:for-each select="//seats/seat">
                                                <span style="border-radius: 50%; padding: 0.3vh">
                                                    <xsl:value-of select='@id' />
                                                </span>
                                            </xsl:for-each>
                                        </xsl:when>
                                    </xsl:choose>
                                </span>
                            </div>
                        </xsl:for-each>
                    </div>
                </div>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
