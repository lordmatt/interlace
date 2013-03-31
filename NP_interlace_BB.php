<?php
/**

Interlace_BB adds BB code markup to Interlace.

(c)Copyright 2008, 2013 Lord Matt

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

*/


/*

[url]ww.etc.com[/url]
[url=www.etc.com]link[/url]
===== 5th level para =====
==== 4th level ====
=== 3rd level ===
== 1st level ==
---- line (the same as <hr />)
--text-- give <strike>text</strike>
[img]mydomain.com/pic.jpg[/img]
[b][i][u]blod, itallic and underline[/u][/i][/b] 

*/


 
class NP_interlace_BB extends NucleusPlugin {
 
        function getName() { return 'Inter-Lace BB'; }
        function getAuthor() { return 'Lord Matt'; }
        function getURL()    { return 'https://github.com/lordmatt/interlace'; }
        function getVersion() { return '1.0.0 Blobface'; }
        function getDescription() {
                return 'Inter-Lace BB - BB Code Mark up Nucleus CMS';
        }

        function getEventList() {
                return array('Interlace_markup');
        }

        function supportsFeature($what) {
                switch($what) {
                        case 'HelpPage':
                                return 0;
                        break;
                        case 'SqlTablePrefix':
                                return 1;
                        break;
                        default:
                                return 0;
                }
        }
  
        function event_Interlace_markup(&$markup) {
                // MARK UP PATTERNS
                //[url] tags, [b], [i] & [u]
                //Auto link all urls with and without http://
                //Allows more cut n past (for forum) style codes to work.
                //The wiki mark-up allows: heading, strikeout, dividing line and 
                // Newbie Friendly.
                $basic = "[.*?^\n]"; //Any char but not a line break
                $markup[] = array("pattern" => "/\[url=($basic)\](.*?)\[\/url\]/", "target" => "<a href=\"\\1\">\\2</a>");
                $markup[] = array("pattern" => "/\[url\]($basic)\[\/url\]/", "target" => "<a href=\"\\1\">\\1</a>");
                $markup[] = array("pattern" => "/={5}($basic)={5}/", "target" => "<h5>\\1</h5>");	//The levels must be reverse order	
                $markup[] = array("pattern" => "/={4}($basic)={4}/", "target" => "<h4>\\1</h4>");
                $markup[] = array("pattern" => "/===($basic)===/", "target" => "<h3>\\1</h3>");
                $markup[] = array("pattern" => "/==($basic)==/", "target" => "<h2>\\1</h2>");
                $markup[] = array("pattern" => "/=(.*?)=/", "target" => "<h1>\\1</h1>");
                $markup[] = array("pattern" => "/----/", "target" => "<hr />");
                $markup[] = array("pattern" => "/[^!^<]--($basic)--^>/", "target" => "<strike>\\1</strike>"); //This wants improving to disallow line breaks
                $markup[] = array("pattern" => "/\[img\](.*?)\[\/img\]/", "target" => "<img src=\"\\1\">");
                $markup[] = array("pattern" => "/((http)+(s)?:(//)|(www\.))((\w|\.|\-|_)+)(/)?(\S+)?/i",  "target" => "<a href=\"http\\3://\\5\\6\\8\\9\" target=\"_blank\" title=\"\\0\">\\5\\6</a>");
                $markup[] = array("pattern" => "/\[([biu])\]/i", "target" => "<\\1>");
                $markup[] = array("pattern" => "/\[\/([biu])\]/i", "target" => "</\\1>");
                $markup[] = array("pattern" => "/(\n\n|\r\r|\n\r\n\r)/", "target" => "<br />");
                $markup[] = array("pattern" => "/\[br\]/", "target" => "<br />");
        }


}

