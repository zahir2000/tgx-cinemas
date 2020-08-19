<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
                xmlns:php="http://php.net/xsl" 
                xmlns:lxslt="http://xml.apache.org/xslt"
                version="1.0">
    
    <xsl:output method="html"/>
    <xsl:template match="/">
        <html>
            <link rel="stylesheet" type="text/css" href="SeatLayout/RegularSeatLayout.css"/>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" />
            
            <script type="text/javascript">
                var seatCtr = 0;
                        
                function changeImage(element, type) {
                if(type == 'double'){
                element.src = element.bln ? "../img/doubleSeat.svg" : "../img/selectedSeat.svg";             
                }
                else if(type == 'regular'){
                element.src = element.bln ? "../img/regularSeat.svg" : "../img/selectedSeat.svg";
                }

                var seatId = element.name;
                var seatType = type;

                if(!element.bln){
                var action='add';
                seatCtr++;
                
                $.ajax({
                type: "POST",
                url: 'SeatsSession.php',
                data: { seatId : seatId, action : action, seatType : seatType }
                });
                
                } else {
                var action='remove';
                seatCtr--;
                
                $.ajax({
                type: "POST",
                url: 'SeatsSession.php',
                data: { seatId : seatId, action : action, seatType : seatType }
                });
                }

                element.bln = !element.bln;
                }
                
                function getUrlParameter(name) {
                    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
                    var regex = new RegExp('[\\?&amp;]' + name + '=([^&amp;#]*)');
                    var results = regex.exec(location.search);
                    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
                }
                
                function goToPayment(){
                if(seatCtr > 0){
                var showtimeId = getUrlParameter('id');
                window.location.href = "SeatCount.php?id=" + showtimeId;
                } else {
                alert('Select a seat first!');
                }
                }         
            </script>
            
            <body>
                <div class="seats">
                    <h2>
                        <center>Select Your Seats</center>
                    </h2>
                    <span>
                        <center>Screen Here</center>
                    </span>
                    <xsl:for-each select="hall/row">
                        <div class="row">
                            <div class="row-id">
                                <xsl:value-of select='@id' />
                            </div>
                            
                            <xsl:variable name="rowID" select="@id"/>
                            
                            <xsl:for-each select='seat'>
                                <xsl:variable name="seatID" select="@id"/>
                                <xsl:choose>
                                    <xsl:when test=". = 'Booked'">
                                        <img src='../img/soldSeat.svg' />
                                    </xsl:when>
                                    
                                    <xsl:when test="@type = 'Double'">
                                        <img src='../img/doubleSeat.svg' name='{$rowID}{$seatID}' onclick="changeImage(this, 'double')" />
                                    </xsl:when>
                                    
                                    <xsl:otherwise>
                                        <img src='../img/regularSeat.svg' name='{$rowID}{$seatID}' onclick="changeImage(this, 'regular')" />
                                    </xsl:otherwise>
                                </xsl:choose>
                            </xsl:for-each>
                            
                            <div class="row-id">
                                <xsl:value-of select='@id' />
                            </div>
                        </div>
                        <br/>
                    </xsl:for-each>
                    <div class="button">
                        <input type="button" onclick="goToPayment()" value="Proceed to Payment"/>
                    </div>
                </div>
            </body>
            
            
        </html>
    </xsl:template>

</xsl:stylesheet>
