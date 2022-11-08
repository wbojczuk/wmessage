const messageScript = {
    init: ()=>{
        const localUserData = userData;
        const localCurrentUser = currentUser;
        const localFriendRequests = friendRequests;
        const localFriends = currentFriends;
        let requestedUser;

        let chatDown = false;


        const friendExpandedWrapper = document.getElementById("friendExpandedWrapper");
        const openChatExpandedLink = document.getElementById("openChatLink");

        // CHECK IF CHAT WINDOW SHOULD BE OPEN
        const urlParams = new URLSearchParams(window.location.search);
        if(urlParams.get("openchat")){
            requestedUser = urlParams.get("openchat");
            openChat();
        }
        
        function openChat(){
            let fetchUrl = `data/messages/${requestedUser}_${localCurrentUser}.txt`;
            CheckFileExist(fetchUrl);
        }


    // OPEN CHAT LINK LISTENERS
        openChatExpandedLink.addEventListener("click", (evt)=>{
           requestedUser = openChatExpandedLink.dataset.user;
            friendExpandedWrapper.style.transform = "translateY(-100%)";

            let fetchUrl = `data/messages/${requestedUser}_${localCurrentUser}.txt`;
            // OPEN CHAT TEXT VIA FETCH
            CheckFileExist(fetchUrl);


        });

        


        function CheckFileExist(fetchUrl) {
                fetch(fetchUrl, {method: "HEAD", cache: "no-store"}).then(res => {
                    if (res.status == 404){
                        fetchUrl = `data/messages/${localCurrentUser}_${requestedUser}.txt`;
                        fetch(fetchUrl, {cache: "no-store"})
                        .then((response) => response.text())
                        .then((text) => {getChats(text)});
                    };
                    if (res.status == 200){
                        fetch(fetchUrl, {cache: "no-store"})
                        .then((response) => response.text())
                        .then((text) => {getChats(text)});};
                   
                }) 
            
        
        }

        function getChats(chats){
            const mainChatWrapper = document.querySelector(".main-chat-wrapper");
            
            dropChatElem();
            
            const chatArray = chats.split("`");
            chatArray.pop();

            
            let currentIDS = [];
            const mainWrapperText = mainChatWrapper.querySelector(".wrapper-chats");
            mainWrapperText.innerHTML = "";
            chatArray.forEach((chat)=>{
                const tempDiv = document.createElement("div");
                const chatData = chat.split("~");
                console.log(chatData)
                const curClass = (chatData[0] == localCurrentUser) ? "chat-user" : "chat-friend";
                tempDiv.className = curClass + " chat";
                tempDiv.textContent = chatData[1];

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
            // Button Listener
            const currentID = (currentIDS[currentIDS.length - 1] != null) ? (currentIDS[currentIDS.length - 1] + 1) : 0;
        document.getElementById("chatSendButton").onclick = ()=>{
            document.getElementById("chatForm").setAttribute("action", `index.php?openchat=${requestedUser}&chatid=${currentID}`);
            document.getElementById("chatForm").submit();
        };
        }
        
        function dropChatElem(){
            document.querySelector(".wrapper-chats").style.top = "0";
            document.getElementById("chatInput").style.left = "0";
            document.getElementById("chatSendButton").style.right = "0";
        }
    }

};

messageScript.init();