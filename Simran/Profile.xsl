<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/">
        <html>
            <head>
                <title>Customer Profile</title>
            </head>
            <body>
                <h1>Customer Profile</h1>
                <hr />
                <xsl:apply-templates/>
            </body>
        </html>
    </xsl:template>
    
    <xsl:template match="user">
        <table border="1">
            <tr>
                <th>UserID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Number</th>
                <th>Date Of Birth</th>
                <th>Gender</th>
                <th>Address</th>
            </tr>
            <xsl:for-each select="//user">
                <xsl:sort select="@id"/>
                <tr>
                    <td>
                        <xsl:value-of select="@id"/>
                    </td>
                    <td>
                        <xsl:value-of select="name"/>
                    </td>
                    <td>
                        <xsl:value-of select="email"/>
                    </td>
                    <td>
                        <xsl:value-of select="number"/>
                    </td>
                    <td>
                        <xsl:value-of select="dob"/>
                    </td>
                    <td>
                        <xsl:value-of select="gender"/>
                    </td>
                    <td>
                        <xsl:value-of select="address"/>
                    </td>
                </tr>
            </xsl:for-each>
        </table>
    </xsl:template>
</xsl:stylesheet>
