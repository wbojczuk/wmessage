const messageScript = {
    init: ()=>{
        const localUserData = userData;
        const localCurrentUser = currentUser;
        const localFriendRequests = friendRequests;
        const localFriends = currentFriends;
        let requestedUser;
        let chatDown = false;
        let currentID;
        let fetchQueued = false;
        let lastMod = null;
        let fetchUrl;


        const friendExpandedWrapper = document.getElementById("friendExpandedWrapper");
        const openChatExpandedLink = document.getElementById("openChatLink");

        


        // CHECK IF CHAT WINDOW SHOULD BE OPEN
        const urlParams = new URLSearchParams(window.location.search);
        if(urlParams.get("openchat")){
            requestedUser = urlParams.get("openchat");
            openChat("bottom");
        }
        
        function openChat(scrollType){
            let sortedUsers = [requestedUser, localCurrentUser];
            sortedUsers.sort();
            fetchUrl = `data/messages/${sortedUsers[0]}_${sortedUsers[1]}.txt`;
            fetch(fetchUrl, {cache: "no-store"})
                .then((response) => response.text())
                .then((text) => {getChats(text, scrollType)});
        }
        ;

    // OPEN CHAT LINK LISTENERS
        openChatExpandedLink.addEventListener("click", (evt)=>{
           requestedUser = openChatExpandedLink.dataset.user;
            friendExpandedWrapper.style.transform = "translateY(-100%)";
             openChat("bottom")


        });


        let currentIDS = [];
        function getChats(chats, scrollType){
            const mainChatWrapper = document.querySelector(".main-chat-wrapper");
            
            showChatElem();
            
            const chatArray = chats.split("`");
            chatArray.pop();

            
            
            const mainWrapperText = mainChatWrapper.querySelector(".wrapper-chats");
            mainWrapperText.innerHTML = "";
            chatArray.forEach((chat)=>{
                const tempDiv = document.createElement("div");
                const chatData = chat.split("~");
                const curClass = (chatData[0] == localCurrentUser) ? "chat-user" : "chat-friend";
                tempDiv.className = curClass + " chat";
                tempDiv.innerHTML = chatData[1];

                if(chatArray.length > 0){
                    currentIDS.push(parseFloat(chatData[2]));
                }else{
                    currentIDS.push(0);
                }
                
                const chatWrapper = document.createElement("div");
                chatWrapper.className = "chat-wrapper";
                chatWrapper.append(tempDiv);
                mainWrapperText.append(chatWrapper);
                
                
               
            });
            currentID = (currentIDS[currentIDS.length - 1] != null) ? (currentIDS[currentIDS.length - 1] + 1) : 0;
            if((scrollType) == "bottom"){
                mainWrapperText.scrollTop = mainWrapperText.scrollHeight;
            }else{
                mainWrapperText.scrollTop = parseFloat(scrollType);
            }

            // Button Listener
        
            document.getElementById("chatSendButton").onclick = ()=>{
            document.getElementById("chatForm").setAttribute("action", `index.php?openchat=${requestedUser}&chatid=${currentID}`);
            document.getElementById("chatForm").submit();
        };
        // CHat input onenter post message
        document.getElementById("chatInput").onkeydown = (evt)=>{
            let shiftKey = evt.shiftKey;
            if(((evt.code == "Enter") || (evt.code == "NumpadEnter")) && (shiftKey== false)){
                document.getElementById("chatForm").setAttribute("action", `index.php?openchat=${requestedUser}&chatid=${currentID}`);
            document.getElementById("chatForm").submit();
                
            }
            
        };
            

        fetchQueued = false;
        }

        

        // CLOSE CHAT LISTENER

        const closeChat =  document.getElementById("closeChat");
        closeChat.addEventListener("click", ()=>{
            removeChatElem();
        });

        
        
        
        function showChatElem(){
            chatDown = true;
            document.querySelector(".main-chat-wrapper").style.display = "inline-block";
            
        }
        function removeChatElem(){
            chatDown = false;
            document.querySelector(".main-chat-wrapper").style.display = "none";
            
        }

        function lasttMod(file){
            
            fetch(file, {
                method: "HEAD",
                cache: "no-store"
            })
            .then((res)=>{
                if(lastMod == null){
                    lastMod = res.headers.get("Last-Modified");
                }else if(lastMod != res.headers.get("Last-Modified")){
                    const wrapperChats = document.querySelector(".wrapper-chats");
                    const userScroll = wrapperChats.scrollTop;
                    const elemMaxScroll = wrapperChats.scrollHeight;
                    const scrollAmt = (Math.floor(wrapperChats.clientHeight + userScroll) == Math.floor(elemMaxScroll)) ? "bottom" : userScroll;
                    lastMod = res.headers.get("Last-Modified");
                    openChat(scrollAmt);
                }
                
            })
        }
        // REFRESH COUNTER/LISTENER
        let refreshCounter = 1;
        setInterval(()=>{
            if(chatDown){
                --refreshCounter;
                if(refreshCounter == 0 && !fetchQueued){
                    
                    refreshCounter = 1;
                    lasttMod(fetchUrl)
                    
                    
                }
            }
        } ,1000);
        
    },

};

messageScript.init();