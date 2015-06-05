/**
 * Node Server Management
 * 
 * @author Chris Darby
 * @version 0.1
 * @license www.gnu.org/licenses/gpl-2.0.html GPL v2
 */

var http = require('http');
var url = "http://95.85.22.103/auto/";
var gap = 1800;
var t;

function primaryProcess() {
    clearTimeout(t);
    
    var client = http.createClient(80, url + "to_crawl");
    request = client.request();
    request.on('response', function(res) {
        res.on('data', function(data) {
            var txt = data.toString();
            var arr = JSON.parse(txt);

            for (var i = 0; i < arr.length; i++) {
                console.log(arr[i]);
            }
        });
    });

    request.end();
    
    t = setTimeout("primaryProcess()",(gap * 1000));
}

function crawlFeed(feed) {
    var client = http.createClient(80, url + "go/" + feed);
    request = client.request();
    request.on('response', function(res) {
        res.on('data', function(data) {
            console.log("Feed processing #" + feed);
        });
    });

    request.end();
}

primaryProcess();