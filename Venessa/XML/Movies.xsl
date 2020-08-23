<?xml version="1.0" encoding="UTF-8"?>
<!--
    @author: Venessa Choo Wei Ling
-->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:php="http://php.net/xsl" 
                xmlns:lxslt="http://xml.apache.org/xslt" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/">
        <html>
            <head>
                <title>TGX Cinemas Movies From XML</title>
            </head>
            <body>
                <h1>TGX Cinemas Movies From XML</h1>
                
                <table border="1">
                    <thead>
                        <tr>
                            <th>Movie ID</th>
                            <th>Name</th>
                            <th>Length (min)</th>
                            <th>Status</th>
                            <th>Genre</th>
                            <th>Release Date</th>
                        </tr>
                    </thead>
                    <xsl:for-each select="movies/movie">
                        <xsl:sort select="@movieID" order="ascending"/>
                        <tr>
                            <td>
                                <xsl:value-of select="movieID"/>
                            </td>
                            <td>
                                <xsl:value-of select="name"/>
                            </td>
                            <td>
                                <xsl:value-of select="length"/>
                            </td>
                            <td>
                                <xsl:value-of select="status"/>
                            </td>
                            <td>
                                <xsl:value-of select="genre"/>
                            </td>
                            <td>
                                <xsl:value-of select="releaseDate"/>
                            </td>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
