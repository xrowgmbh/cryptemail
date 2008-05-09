function showmail(nospamplease, idontlikespam, nothanks, no, way){
var str_out = ''; 
var num_out = '';
var num_in;
var hex = '0123456789abcdef'
num_out = nospamplease;  
for(i = 0; i < num_out.length; i += 2) {
num_in1 = ''
num_in = parseInt(num_out.substr(i,2)) + 23;
while (num_in != 0) {
num_in1 = hex.charAt(num_in%16)+num_in1;
num_in = num_in >> 4;}
num_in = unescape('%' + num_in1);
str_out += num_in;
str_out = unescape(str_out);}
nospamplease = str_out;
speakfriendandenter = '&#109;&#97;&#105;&#108;&#116;&#111;:' + nospamplease;
voila = '<a href="' + speakfriendandenter + '" title="'+ nospamplease + '">';
if((idontlikespam != "") && (nothanks != "")) voila = idontlikespam  + " " + voila;
else if((idontlikespam != "") && (nothanks == "")) voila += idontlikespam;
if(nothanks != "") voila += '<img src="' + nothanks + '" width="' + no + '" height="' + way + '" border="0" alt="' + nospamplease + '" />' ;
else if((idontlikespam == "") && (nothanks == "")) voila += nospamplease;
voila += '</a>';
document.write(voila);
}