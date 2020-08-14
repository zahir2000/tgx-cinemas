<?xml version="1.0" encoding="UTF-8"?>

<!--
    Document   : seats.xsl
    Created on : August 14, 2020, 11:18 PM
    Author     : Zahir
    Description:
        Purpose of transformation follows.
-->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/> 
    <xsl:template match="/">
        <html>
            <link rel="stylesheet" type="text/css" href="seats.css"/>
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
                        <xsl:for-each select="/showtimes/showtime[@id=2]">
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
                        </xsl:for-each>
                    </div>
                </div>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
