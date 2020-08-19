<?xml version="1.0" encoding="UTF-8"?>

<!--
    Document   : Cinema.xsl
    Created on : August 19, 2020, 2:55 PM
    Author     : Jaloliddin
    Description:
        Purpose of transformation follows.
-->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/">
        <html>
            <head>
                <title>TGX Cinemas Directory</title>
            </head>
            <body>
                <h1>TGX Cinemas Directory</h1>
                <hr/>
                <xsl:apply-templates/>
            </body>
        </html>
    </xsl:template>
    
    <xsl:template match="cinemas">
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
            </tr>
            <xsl:for-each select="//cinema">
                <xsl:sort select="@id" order="ascending"/>
                <tr>
                    <td>
                        <xsl:value-of select="@id"/>
                    </td>
                    <td>
                        <xsl:value-of select="name"/>
                    </td>
                    <td>
                        <xsl:value-of select="location"/>
                    </td>
                </tr>
            </xsl:for-each>
        </table>
    </xsl:template>

</xsl:stylesheet>
