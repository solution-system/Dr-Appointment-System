function getCookie(c_name)
{
   var i,x,y,ARRcookies=document.cookie.split(";");
   for (i=0;i<ARRcookies.length;i++)
   {
      x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
      y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
      x=x.replace(/^\s+|\s+$/g,"");
      if (x==c_name)
      {
         return unescape(y);
      }
   }
}

function setCookie(c_name,value,exdays)
{
   var exdate=new Date();
   exdate.setDate(exdate.getDate() + exdays);
   var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
   document.cookie=c_name + "=" + c_value + "; domain='.Dr. Website.com'";
}

function Update_Cookie(cookie_name, uid)
{
   var temp=Cookies.get(cookie_name);
   if (temp!=null && temp!="")
   {
      var x,arr = temp.split("|");
      for (i=0;i<arr.length;i++)
      {
         x=arr[i];
         if (x==uid)
         {
            return true;
         }
      }
      // setCookie(cookie_name, temp + "|" + uid);
      Cookies.set(cookie_name, temp + "|" + uid, null, null, null, '.Dr. Website.com');
      return true;
   }
   else
   {
      Cookies.set(cookie_name, uid, null, null, null, '.Dr. Website.com');
      return true;
   }
}
function Check_Cookie(cookie_name, uid)
{
   var temp=getCookie(cookie_name);
   // debug('Check_Cookie temp: ' + temp + '-->' + uid);
   if (temp!=null && temp!="")
   {
      var x,arr = temp.split("|");
      for (i=0;i<arr.length;i++)
      {
         x=arr[i];
         if (x==uid)
         {
            // debug('Check_Cookie x: ' + x + '-->' + uid);
            return true;
         }
      }
      return false;
   }
   else
   {
      // setCookie(cookie_name, uid,365);
      return false;
   }
}