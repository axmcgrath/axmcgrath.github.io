<?xml version="1.0" encoding="UTF-8"?>
<html xsl:version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<body style="background-color:#222222;font-family:sans-serif">
  <h1 style="color:#ffffff;padding:1%;width:98%">Where should you live?</h1>
  <xsl:for-each select="solarsystem/planet">
    <div style="width:98%;display:block;float:left;padding:1%;color:#ffffff;margin-left:4%">
      <span style="font-weight:bold;font-size:180%;margin:1%;">
        <xsl:value-of select="name"/></span>  <xsl:value-of select="life"/>
      </div>
    </xsl:for-each>
  <xsl:for-each select="solarsystem/dwarfplanet">
    <div style="width:98%;display:block;float:left;padding:1%;color:#bbbbbb;margin-left:4%">
      <span style="font-weight:bold;font-size:150%;margin:1%;">
        <xsl:value-of select="name"/></span>  <xsl:value-of select="life"/>
      </div>
    </xsl:for-each>
  </body>
</html>
