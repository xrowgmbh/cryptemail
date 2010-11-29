<code>
/*
    Crypt Email for eZ publish
    Copyright (C) 2005  xrow GbR, Hannover Germany, http://xrow.de

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

### BEGIN INIT INFO
# Provides:     cryptemail
# Depends:		Javascript engine in browser
# OS:			ALL
# Version:		> eZ 3.5		
# Developed:	Björn Dieding  ( bjoern@xrow.de )
# Short-Description: spam protection spamfilter
# Description:       A better SPAM protection with encryted mailto: part.
# Resources:	http://pubsvn.ez.no/community/trunk/extension/cryptemail/
### END INIT INFO
</code>

#### Setup ####

activate extension

#### Usage ####

Any time in a template do.

<code>
{'... <a href="mailto:bjoern@example.com">bjoern@example.com</a> ...'|cryptemail}
</code>
or
<code>
{'... bjoern@example.com ...'|cryptemail}
</code>

Result:

<code>
... <script type="text/javascript"><!--//--><![CDATA[//><!-- 
showmail('7583887891874197918896237778', 'bjoern<span class="spamfilter">SPAMFILTER</span>@example.com', '', '', '' )
//--><!]]></script> ...
</code>



If you would like to have email address without spam filter:

add in ezoe_attributes.ini.append.php something like that (important for us: LinkType[mailtonospamfilter:]=Mail (no spam filter))
[Attribute_href]
LinkType[]
LinkType[eznode://]=eznode
LinkType[ezobject://]=ezobject
LinkType[ftp://]=Ftp
LinkType[file://://]=File
LinkType[http://]=Http
LinkType[https://]=Https
LinkType[mailto:]=Mail
LinkType[mailtonospamfilter:]=Mail (no spam filter)
LinkType[#]=Anchor
LinkType[0]=Other

In eZ OE choose for a link 'Mail (no spam filter)' and enter your email...