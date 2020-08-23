<?xml version="1.0" encoding="UTF-8"?>

<!--
    Document   : Receipt.xsl
    Created on : August 18, 2020, 6:18 PM
    Author     : Zahir
    Description:
        Purpose of transformation follows.
-->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/">
        <html>
            <link rel="stylesheet" type="text/css" href="Receipt.css"/>
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" crossorigin="anonymous"/>
            
            <script type="text/javascript">
                function goToHome(){
                window.location.href = "/Assignment/Home.php";      
                }
            </script>
            
            <body>
                <div class="receipt-information">
                    <div class="dotted">
                        <xsl:for-each select="//booking">
                            <h3 style="margin-bottom: 0" >
                                <center>
                                    <xsl:value-of select='//movie/name' />
                                    <xsl:choose>
                                        <xsl:when test="//movie/ageRestriction = '13'">
                                            <img src='../img/P13.png' alt='PG13 Rating' />
                                        </xsl:when>
                                        <xsl:when test="//movie/ageRestriction = '18'">
                                            <img src='../img/P18.png' alt='PG18 Rating' />
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <img src='../img/PU.png' alt='PGU Rating' />
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </center>
                            </h3>
                            
                            <table>
                                <colgroup>
                                    <col style="width: 42%" />
                                    <col style="width: 29%" />
                                    <col style="width: 29%" />
                                </colgroup>
                                <tr>
                                    <td>
                                        <span>
                                            <i class="fas fa-2x fa-map-marker-alt"></i>
                                            <xsl:value-of select='//cinema/name' />
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            <i class="fas fa-2x fa-glasses"></i>
                                            <xsl:value-of select='//cinema/hall/experience' />
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            <img src='../img/screen-black.png' alt='Hall Screen' />
                                            <xsl:value-of select='//cinema/hall/@id' />
                                        </span>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="padding-bottom: 2vh">
                                        <span>
                                            <i class="far fa-2x fa-calendar-alt"></i>
                                            <xsl:value-of select="concat(substring(//date, 9, 2),'-',substring(//date, 6, 2),'-', substring(//date, 1, 4))" />
                                        </span>
                                    </td>
                                    <td style="padding-bottom: 2vh">
                                        <span>
                                            <i class="far fa-2x fa-clock"></i>
                                            <xsl:value-of select='//time' />
                                        </span>
                                    </td>
                                    <td style="padding-bottom: 2vh">
                                        <span>
                                            <i class="fas fa-2x fa-couch"></i>
                                            <xsl:value-of select='count(//seat)' /> Seat(s)
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="dotted-td" style="padding: 2vh 0 !important; margin: 2vh 0 !important;">
                                        <span>
                                            <i class="fas fa-money-check-alt"></i>
                                            <xsl:value-of select='//method' />
                                            (<xsl:value-of select='//payment/name|//email' />)
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="dotted-td-second" style="padding: 2vh 0 !important; margin: 2vh 0 !important;">
                                        <span>
                                            RM <xsl:value-of select="format-number(//totalPrice, '#.00##')" />
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding-bottom: 3vh;">
                                        <xsl:for-each select="//seat">
                                            <span class="seat">
                                                <xsl:value-of select='@id' />
                                            </span>
                                        </xsl:for-each>
                                    </td>
                                </tr>
                            </table>
                        </xsl:for-each>
                    </div>
                    
                    <center>
                        <input class="button-receipt" type="button" onclick="goToHome()" value="Back to Home Page"/>
                    </center>
                </div>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
