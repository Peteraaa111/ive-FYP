package android.exercise.travelhk.firebase.chat;

public class MessageList {


    private String name;
    private String accountid;
    private String lastMessage;


    private int unseenMessages;


    public MessageList(String name, String accountid, String lastMessage, int unseenMessages) {
        this.name = name;
        this.accountid = accountid;
        this.lastMessage = lastMessage;
        this.unseenMessages = unseenMessages;
    }

    public String getName() {
        return name;
    }

    public String getAccountid() {
        return accountid;
    }

    public String getLastMessage() {
        return lastMessage;
    }

    public int getUnseenMessages() {
        return unseenMessages;
    }
}
