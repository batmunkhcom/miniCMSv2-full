<?php
#Copyright 2006 Svetlozar Petrov
#All Rights Reserved
#svetlozar@svetlozar.net
#http://svetlozar.net

#Script to import the names and emails from gmail contact list


class GMailer extends baseFunction
{
    var $location = "";
    var $cookiearr = array();

    #Globals Section, $location and $cookiearr should be used in any script that uses
    #getAddressbook function
    #function getAddressbook, accepts as arguments $login (the username) and $password
    #returns array of: array of the names and array of the emails if login successful
    #otherwise returns 1 if login is invalid and 2 if username or password was not specified
   
    function getAddressbook($login, $password)

    {
         #the globals will be updated/used in the read_header function
         global $location;
         global $cookiearr;
         global $ch;

        #check if username and password was given:
        if ((isset($login) && trim($login)=="") || (isset($password) && trim($password)==""))
        {
              return false;
        }
        
        #initialize the curl session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://mail.google.com/mail/");
        curl_setopt($ch, CURLOPT_REFERER, "");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        //curl_setopt($ch, CURLOPT_HEADERFUNCTION, 'read_header');
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, array($this, 'read_header'));  
        
        #get the html from gmail.com
        $html = curl_exec($ch);
        $matches = array();
        $actionarr = array();
        
        $action = "https://www.google.com/accounts/ServiceLoginAuth";
    
        #parse the login form:
        #parse all the hidden elements of the form
        preg_match_all('/<input type\="hidden" name\="([^"]+)".*?value\="([^"]*)"[^>]*>/si', $html, $matches);
        $values = $matches[2];
        $params = "";
        
        $i=0;
        foreach ($matches[1] as $name)
        {
          $params .= "$name=" . urlencode($values[$i]) . "&";
          ++$i;
        }
        
        $login = urlencode($login);
        $password = urlencode($password);
        
        curl_setopt($ch, CURLOPT_URL,$action);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params ."Email=$login&Passwd=$password&PersistentCookie=");
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        $html = curl_exec($ch);
    
        #test if login was successful:
        if (preg_match('/url=([^"]*)/', $html, $actionarr)!=0)
        {   
            $location = $actionarr[1];
            $location = urldecode($location);  
    
        }
        else
        {
            return false;
        }
    
    
        
        $location2=trim(html_entity_decode($location),"\'");
        preg_match_all('/continue\=(.*)$/',$location2,$matches);
      
        $finalLocation=urldecode($matches[1][0]);
       
        if($finalLocation!="")   
        {
            $data=explode("?",$finalLocation);
        }
        else 
        {
            $data=explode("?",$location2);
        }
      
       $ch1=curl_init();

       curl_setopt($ch1, CURLOPT_URL, $data[0]);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, 0);
       curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch1, CURLOPT_HEADER, true);
       curl_setopt($ch1, CURLOPT_POST, 1);
       curl_setopt($ch1, CURLOPT_POSTFIELDS, $data[1]);
    
       $html1 = curl_exec($ch1);
    
       $cokkies1=$this->getCookies($html1);
       $location1=$this->getLocation($html1); 
     
       $ch2=curl_init();

       curl_setopt($ch2, CURLOPT_URL, "https://mail.google.com/mail/h/?v=cl&pnl=a&f=1");
       curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
       curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch2, CURLOPT_HEADER, true);
       curl_setopt($ch2, CURLOPT_COOKIE, $cokkies1);
       curl_setopt($ch2, CURLOPT_FOLLOWLOCATION,1);
       $html2 = curl_exec($ch2);
    
       $html2 = str_replace("\n","",$html2);     
       $tempname = split('<b>All&nbsp;Contacts</b>',$html2,2);
       preg_match_all('/<b>([^\<]*)/s',$tempname[1],$name);
       $tempemail = preg_replace('/<b>([^\<]*)/s','',$tempname[1]);
       $emails = explode("&nbsp;",strip_tags($tempemail));
       $tot_contacts = strip_tags($name[0][0]) + 2;
       
       for($i=2,$j=4;$i<$tot_contacts;$i++,$j++)
       {
            $result['name'][]=trim(strip_tags($name[0][$i]));
           $result['email'][]=trim($emails[$j]);
       }
       return $result;
    }


    
}
?>
