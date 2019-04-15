/*

Cookies.js

An object allowing cookies to be created, retrieved, and deleted

Created by Stephen Morley - http://code.stephenmorley.org/ - and released under
the terms of the CC0 1.0 Universal legal code:

http://creativecommons.org/publicdomain/zero/1.0/legalcode

*/

// create the Cookies object
var Cookies =
    {

      /* Returns the value of the specified cookie. The parameters are:
       *
       * name               - the name of the cookie
       * preserveDuplicates - true to return an array containing the values of
       *                      all cookies with the specified name, or false to
       *                      return only the value of the first cookie with the
       *                      specified name (or undefined if no cookies have
       *                      the specified name). This optional parameter
       *                      defaults to false.
       */
      get : function(name, preserveDuplicates){

        // initialise the list of values
        var values = [];

        // loop over the cookies
        var cookies = document.cookie.split(/; */);
        for (var index = 0; index < cookies.length; index ++){

          // if the cookie has the requested name, add its value to the list
          var details = cookies[index].split('=');
          if (details[0] == name) values.push(decodeURIComponent(details[1]));

        }

        // return the first value or all values as appropriate
        return (preserveDuplicates ? values : values[0]);

      },

      /* Sets a cookie. The parameters are:
       *
       * name    - the name of the cookie
       * value   - the value of the cookie
       * expires - the expiry date for the cookie, either as an instance of Date
       *           or a number of days. This parameter is optional, and if
       *           omitted the cookie expires at the end of the browser session.
       * path    - the path for which the cookie should be set. This optional
       *           parameter defaults to the current path.
       * domain  - the domain for which the cookie should be set. This optional
       *           parameter defaults to the current domain.
       * secure  - true if the cookie should only be sent over encrypted
       *           connections, and false if the cookie can be sent over any
       *           connection. This optional parameter defaults to false.
       */
      set : function(name, value, expires, path, domain, secure){

        // initialise the cookie data
        var cookieData = [name + '=' + encodeURIComponent(value)];

        // extend the cookie data with the expiry date if necessary
        if (typeof expires == 'number'){
          expires = new Date((new Date()).getTime() + expires * 86400000);
        }
        if (expires) cookieData.push('expires=' + expires.toGMTString());

        // extend the cookie data with the path and domain if necessary
        if (path)   cookieData.push('path=' + path);
        if (domain) cookieData.push('domain=' + domain);

        // extend the cookie data with the secure keyword if necessary
        if (secure) cookieData.push('secure');

        // set the cookie
        document.cookie = cookieData.join('; ');

      },

      /* Clears a cookie. The parameter is:
       *
       * name - the name of the cookie
       */
      clear : function(name){

        // clear the cookie
        this.set(name, '', -1);

      }

    };
