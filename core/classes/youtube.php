<?

/*******************************************************************************
 *                      Youtube Class
 *******************************************************************************
 *      Author:     Vikas Patial
 *      Email:      admin@ngcoders.com
 *      Website:    http://www.ngcoders.com
 *
 *      File:       youtube.php
 *      Version:    1.0.0
 *      Copyright:  (c) 2008 - Vikas Patial
 *                  You are free to use, distribute, and modify this software 
 *                  under the terms of the GNU General Public License.  See the
 *                  included license.txt file.
 *      
 *******************************************************************************
 *  VERION HISTORY:
 *
 *      v1.0.0 [18.9.2008] - Initial Version
 *
 *******************************************************************************
 *  DESCRIPTION:
 *
 *      NOTE: See www.ngcoders.com for the most recent version of this script 
 *      and its usage.
 *
 *******************************************************************************
*/


class youtube {
    
    var $conn = false;
    var $username = "";
    var $password = "";
       
     // login only if required ( 18+ videos ) 
     
    function _login()
    {
        $url = "http://www.youtube.com/login?username=".$this->username."&password=".$this->password."&next=/index&current_form=loginForm&action_login=1";
        $html = $this->conn->get($url);
        
        return strstr($html,"Sign Out")?true:false;
    }
    
    function get($url)
    {
        $this->conn = new Curl('youtube');
        
        $html = $this->conn->get($url);

        if (strstr($html,'please verify you are 18')) 
        {
            if(!$this->_login())
            {
                return false;
            }
            
            $this->conn->cookie = 'is_adult=1';
            $html = $this->conn->get($url);
        }
                
        if(!preg_match('/"video_id": "(.*?)"/', $html, $match) || !preg_match('/"t": "(.*?)"/', $html, $match1))
        {
            return false;
        }
        
        $var_id = $match[1];
        $var_t  = $match1[1];
        
        $url = "http://www.youtube.com/get_video?video_id=".$var_id."&t=".$var_t;
        
        $this->conn->follow = false;
        $this->conn->header = true;

        $html =  $this->conn->get($url);

        if(preg_match('/Location: (.*?)[\r\n]+/',$html,$match))
        {
            return $match[1];
        }
                    
        return $url;
        
    }
    
}	
?>