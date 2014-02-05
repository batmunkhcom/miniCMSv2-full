<?php
//    $memcache = new Memcache;

    # Gets key / value pair into memcache ... called by mysql_query_cache()
    function getCache($key) {
        global $memcache;
        return ($memcache) ? $memcache->get($key) : false;
    }

    # Puts key / value pair into memcache ... called by mysql_query_cache()
    function setCache($key,$object,$timeout = 60) {
        global $memcache;
        return ($memcache) ? $memcache->set($key,$object,MEMCACHE_COMPRESSED,$timeout) : false;
    }

    # Caching version of mysql_query()
    function mysql_query_cache($sql,$linkIdentifier = false,$timeout = 60) {
        if (($cache = getCache(md5("mysql_query" . $sql))) !== false) {
            $cache = false;
            $r = ($linkIdentifier !== false) ? mysql_query($sql,$linkIdentifier) : mysql_query($sql);
            if (is_resource($r) && (($rows = mysql_num_rows($r)) !== 0)) {
                for ($i=0;$i<$rows;$i++) {
                    $fields = mysql_num_fields($r);
                    $row = mysql_fetch_array($r);
                    for ($j=0;$j<$fields;$j++) {
                        if ($i === 0) {
                            $columns[$j] = mysql_field_name($r,$j);
                        }
                        $cache[$i][$columns[$j]] = $row[$j];
                    }
                }
                if (!setCache(md5("mysql_query" . $sql),$cache,$timeout)) {
                    # If we get here, there isn't a memcache daemon running or responding
                }
            }
        }
        return $cache;
    }
?>