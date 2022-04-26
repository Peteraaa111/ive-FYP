package android.exercise.travelhk;

import java.util.HashMap;

public class Constants {
    public static final String KEY_FCM_TOKEN = "fcmToken";
    public static final String KEY_IMAGE_URL = "ImageUrl";
    public static final String KEY_COLLECTION_CHAT = "chat";
    public static final String KEY_SENDER_ID = "senderId";
    public static final String KEY_RECEIVER_ID = "receiverId";
    public static final String KEY_MESSAGE = "message";
    public static final String KEY_TIMESTAMP = "timestamp";
    public static final String KEY_USER_ID = "id";
    public static final String KEY_COLLECTION_CONVERSATIONS = "conversations";
    public static final String KEY_SENDER_NAME = "senderName";
    public static final String KEY_RECEIVER_NAME = "receiverName";
    public static final String KEY_LAST_MESSAGE = "lastMessage";
    public static final String KEY_AVAILABILITY = "availability";
    public static final String REMOTE_MSG_AUTHORIZATION = "Authorization";
    public static final String REMOTE_MSG_CONTENT_TYPE = "Content-Type";
    public static final String REMOTE_MSG_DATA = "data";
    public static final String REMOTE_MSG_REGISTRATION_IDS = "registration_ids";

    public static HashMap<String ,String> remoteMsgHeaders = null;

    public static HashMap<String ,String> getRemoteMsgHeaders(){
        if(remoteMsgHeaders == null){
            remoteMsgHeaders = new HashMap<>();
            remoteMsgHeaders.put(
                    REMOTE_MSG_AUTHORIZATION,
                    "key=AAAAvzrpf3c:APA91bGlD3H398ET-l3uQkBdHUvYgzk9qAu2SIQ7r-f8ox5MbDdWoyuUFPmrWtK3YRARGMSoJxofNMYbbWS-ylxPq_zL04Tys9A4-n0Ou034X_5rmrxeCuQCGTFExv8lBQf8igaFCUSj"
            );
            remoteMsgHeaders.put(
                    REMOTE_MSG_CONTENT_TYPE,
                    "application/json"
            );
        }
        return remoteMsgHeaders;
    }
}
