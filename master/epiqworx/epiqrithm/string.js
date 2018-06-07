//<editor-fold desc="Text Validation" defaultstate="collapsed">
function isInt(value) {
    var text = antiWhiteSpace(value);
    for (k = 0; k < text.length; k++)
    {
        if (text.charCodeAt(k) < 48 || text.charCodeAt(k) > 57)
            return false;
    }
    return true;
}
function antiWhiteSpace(text) {
    var txt = "";
    for (k = 0; k < text.length; k++)
    {
        if (text.charCodeAt(k) > 32)
            txt += text.charAt(k);
    }
    return txt;
}
function isName(txt)
{
    var exp1 = /^(([A-Za-z]+[\-\']?)*([A-Za-z]+)?\s)+([A-Za-z]+[\-\']?)*([A-Za-z]+)?$/;
    var exp2 = /^[a-z\u00C0-\u02AB'´`]+\.?\s([a-z\u00C0-\u02AB'´`]+\.?\s?)+$/i;
    var exp3 = /^[A-Za-z\'\s\.\,]+$/;
    var exp4 = /^\w(\w|\s|['.])*$/;
    
    var regex = new RegExp(exp3);
    if (txt.match(regex))
        return true;
    else
        return false;
}
function isNamePlus(txt,min,max){
    txt = txt.toString().trim();
    if(txt.length<min) return "length below "+min+" chars";
    if(txt.length>max) return "length above "+max+" chars";
    
    if(!txt.match(/^[A-Za-z\'\s\.\,]+$/))   return "name invalid";
    
    return "success";
}
function isAlphabet(value) {
    var text = antiWhiteSpace(value);
    text = text.toUpperCase();
    for (k = 0; k < text.length; k++)
    {
        if (text.charCodeAt(k) < 65 || text.charCodeAt(k) > 90)
            return false;
    }
    return true;
}
function isSymbol(char)
{
    if (char.length === 1)
    {
        if (char.charCodeAt(0) < 48 || (char.charCodeAt(0) > 57 && char.charCodeAt(0) < 65) || (char.charCodeAt(0) > 90 && char.charCodeAt(0) < 97) || char.charCodeAt(0) > 122)
            return true;
    }
    if (char.length > 1)
    {
        for (k = 0; k < char.length; k++)
            if (char.charCodeAt(k) < 48 || (char.charCodeAt(k) > 57 && char.charCodeAt(k) < 65) || (char.charCodeAt(k) > 90 && char.charCodeAt(k) < 97) || char.charCodeAt(k) > 122)
                return true;
    }
    return false;
}
function isValidKey(name, list) {
    for (k = 0; k < list.length; k++) {
        if (name.toUpperCase() === list[k].toUpperCase())
            return false;
    }
    return true;
}
function isEmail(txt)
{
    txt = txt.toString().trim();
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;   //------email regex
    if (txt.match(mailformat))
        return true;
    return false;
}
function isURL(txt)
{
    var exp1 = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
    var exp2 = /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/;
    var exp3 = "^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?";

    if (txt.toLowerCase().match(exp3))
        return true;
    else
        return false;
}
function isStAddress(txt)
{

    var exp1 = /^[a-zA-Z\s\d\/]*\d[a-zA-Z\s\d\/]*$/;
    var exp2 = /^\d+\s[A-z]+\s[A-z]+/g;

    var regex = new RegExp(exp1);
    if (txt.match(regex))
        return true;
    else
        return false;
}
function trim(txt)
{
    var name = txt.replace(/^\s+/, "").replace(/\s+$/, "").replace(/\s+/, " ");
    
    if (name === "")  return false;
    else return name;
}
//</editor-fold>
//<editor-fold desc="Text Padding" defaultstate="collapsed">
function padLeft(nr, n, str) {
    return Array(n - String(nr).length + 1).join(str || '0') + nr;
}
//or as a Number prototype method:
/*
 * examples
 * console.log(padLeft(23,5));
 * => '00023'
 */
//+negetive number
Number.prototype.padLeft = function (n, str) {
    return (this < 0 ? '-' : ' ') + Array(n - String(Math.abs(this)).length + 1).join(str || '0') + (Math.abs(this));
};
/*
 * console.log((-23).padLeft(5)); => '-00023'
 */
function Padder(len, pad) {
    if (len === undefined) {
        len = 1;
    } else if (pad === undefined) {
        pad = '0';
    }
    var pads = ' ';
    while (pads.length < len) {
        pads += pad;
    }
    this.pad = function (what) {
        var s = what.toString();
    };
}
/*
 * var zero4 = new Padder(4);
 * zero4.pad(12);   // "0012"
 * zero4.pad(12345);     // "12345"
 * zero4.pad("xx");     // "00xx"
 * var x3 = new Padder(3,"x");
 * x3.pad(12);  // "x12"
 */
//</editor-fold>