function AddEvents()
{
    var Likebtn = document.querySelector('#like');
    var Dislikebtn = document.querySelector('#dislike');
    var counterdislike = parseInt(document.getElementById('dislikecounter').innerHTML);
    var counterlike = parseInt(document.getElementById('likecounter').innerHTML);

 Likebtn.addEventListener('click', function() {
    var xhr = new XMLHttpRequest();
    
    xhr.onreadystatechange=function(){
        if(xhr.readyState === 4 && xhr.status === 200)
        {
             if (Dislikebtn.classList.contains('dislikebtn')) {
                Dislikebtn.classList.remove('dislikebtn');
                document.getElementById('dislikecounter').innerHTML = --counterdislike;
            } 
            
            Likebtn.disabled=true;
            Dislikebtn.disabled=false;
            Likebtn.classList.toggle('likebtn');
            document.getElementById('likecounter').innerHTML = ++counterlike;
            
            var res = xhr.responseText;
            document.getElementById('reviewed').value=res;
        }else if(xhr.status===404)
        {
            alert("No server response");
        }
    };
    
    
    xhr.open("POST","../Ajax-phpScript/InsertUserReview.php?",true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("bildId="+parseInt(document.getElementById('idmeme').value)+ "&review=1");
});

Dislikebtn.addEventListener('click', function() {
    
    var xhr = new XMLHttpRequest();
    
    
    xhr.onreadystatechange=function(){
        if(xhr.readyState === 4 && xhr.status===200)
        {
            if (Likebtn.classList.contains('likebtn')) {
                Likebtn.classList.remove('likebtn');
                document.getElementById('likecounter').innerHTML= --counterlike;
            } 
            Dislikebtn.disabled=true;
            Likebtn.disabled=false;
            Dislikebtn.classList.toggle('dislikebtn');
            
            document.getElementById('dislikecounter').innerHTML= ++counterdislike;
            
            var res = xhr.responseText;
            document.getElementById('reviewed').value=res;
        }else if(xhr.status===404)
        {
            alert("No server response");
        }
    };
    
    xhr.open("POST","../Ajax-phpScript/InsertUserReview.php?",true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("bildId=" + parseInt(document.getElementById('idmeme').value)  + "&review=0");
});
}

function CheckForReviewStatus()
{
    var ReviewStatus = parseInt(document.getElementById('reviewed').value);
    var Likebtn = document.querySelector('#like');
    var Dislikebtn = document.querySelector('#dislike');
    
    if(ReviewStatus === 1)
    {
        Likebtn.classList.toggle('likebtn');
        Likebtn.disabled=true;         
    }else if(ReviewStatus === 0)
    {
        Dislikebtn.classList.toggle('dislikebtn');
        Dislikebtn.disabled=true;
    }
}



