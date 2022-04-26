package android.exercise.travelhk;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.AppCompatImageView;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.exercise.travelhk.firebase.chat.CUser;
import android.exercise.travelhk.firebase.chat.ChatMessage;
import android.exercise.travelhk.firebase.chat.ConversionListener;
import android.exercise.travelhk.firebase.chat.RecentConversationAdapter;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.firebase.firestore.DocumentChange;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.EventListener;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.QuerySnapshot;
import com.google.firebase.messaging.FirebaseMessaging;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;

public class ChatRoom extends AppCompatActivity implements ConversionListener {
    private PreferenceManager preferenceManager;
    private FloatingActionButton fab;
    private AppCompatImageView back;
    private int type;
    private List<ChatMessage> conversations;
    private RecentConversationAdapter conversationAdapter;
    private RecyclerView recyclerView;
    private FirebaseFirestore database;
    private ProgressBar progressBar;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_chat_room);
        preferenceManager = new PreferenceManager(getApplicationContext());
        TextView name = findViewById(R.id.TextName);
        back = findViewById(R.id.back);
        progressBar = findViewById(R.id.CRprogressBar);
        recyclerView = findViewById(R.id.conversationRecyclerView);
        fab = (FloatingActionButton)findViewById(R.id.fabNewChat);
        name.setText(preferenceManager.getString("name"));
        type = preferenceManager.getInt("type");
        init();
        getToken();
        setListeners();
        listenConversations();
    }

    public void init(){
        conversations = new ArrayList<>();
        conversationAdapter = new RecentConversationAdapter(conversations,this);
        recyclerView.setAdapter(conversationAdapter);
        database = FirebaseFirestore.getInstance();

    }

    public void setListeners(){
        fab.setOnClickListener(v -> startActivity(new Intent(getApplicationContext(),UserActivity.class)));
    }

    public void showToast(String message){
        Toast.makeText(getApplicationContext(),message,Toast.LENGTH_SHORT).show();
    }

    public void listenConversations(){
        database.collection(Constants.KEY_COLLECTION_CONVERSATIONS)
                .whereEqualTo(Constants.KEY_SENDER_ID,preferenceManager.getString(Constants.KEY_USER_ID))
                .addSnapshotListener(eventListener);
        database.collection(Constants.KEY_COLLECTION_CONVERSATIONS)
                .whereEqualTo(Constants.KEY_RECEIVER_ID,preferenceManager.getString(Constants.KEY_USER_ID))
                .addSnapshotListener(eventListener);
    }

    public void getToken(){
        FirebaseMessaging.getInstance().getToken().addOnSuccessListener(this::updataToken);
    }

    public final EventListener<QuerySnapshot> eventListener = (value, error) -> {
        if(error !=null){
            return;
        }
        if(value !=null){
            for (DocumentChange documentChange : value.getDocumentChanges()){
                if(documentChange.getType() == DocumentChange.Type.ADDED){
                    String sendId = documentChange.getDocument().getString(Constants.KEY_SENDER_ID);
                    String receiverId = documentChange.getDocument().getString(Constants.KEY_RECEIVER_ID);

                    ChatMessage chatMessage = new ChatMessage();
                    chatMessage.senderId = sendId;
                    chatMessage.receivedId = receiverId;
                    if(preferenceManager.getString(Constants.KEY_USER_ID).equals(sendId)){
                        chatMessage.conversionName = documentChange.getDocument().getString(Constants.KEY_RECEIVER_NAME);
                        chatMessage.conversionId = documentChange.getDocument().getString(Constants.KEY_RECEIVER_ID);
                    }else{
                        chatMessage.conversionName = documentChange.getDocument().getString(Constants.KEY_SENDER_NAME);
                        chatMessage.conversionId = documentChange.getDocument().getString(Constants.KEY_SENDER_ID);
                    }
                    chatMessage.message = documentChange.getDocument().getString(Constants.KEY_LAST_MESSAGE);
                    chatMessage.dateObject = documentChange.getDocument().getDate(Constants.KEY_TIMESTAMP);
                    conversations.add(chatMessage);
                }else if(documentChange.getType() == DocumentChange.Type.MODIFIED){
                    for(int i =0; i< conversations.size();i++){
                        String senderId = documentChange.getDocument().getString(Constants.KEY_SENDER_ID);
                        String receiverId = documentChange.getDocument().getString(Constants.KEY_RECEIVER_ID);
                        if(conversations.get(i).senderId.equals(senderId)&& conversations.get(i).receivedId.equals(receiverId)){
                            conversations.get(i).message = documentChange.getDocument().getString(Constants.KEY_LAST_MESSAGE);
                            conversations.get(i).dateObject = documentChange.getDocument().getDate(Constants.KEY_TIMESTAMP);
                            break;
                        }
                    }
                }
            }
            Collections.sort(conversations,(obj1, obj2)-> obj2.dateObject.compareTo(obj1.dateObject));
            conversationAdapter.notifyDataSetChanged();
            recyclerView.smoothScrollToPosition(0);
            recyclerView.setVisibility(View.VISIBLE);
            progressBar.setVisibility(View.GONE);
        }
    };

    public void back(View v){
        if(type==1){
            Intent i = new Intent(getApplicationContext(), User.class);
            startActivity(i);
        }else if(type==5){
            Intent i = new Intent(getApplicationContext(), Driver.class);
            startActivity(i);
        }
    }

    public void updataToken(String token){
        FirebaseFirestore database = FirebaseFirestore.getInstance();
        DocumentReference documentReference =
                database.collection("users").document
                        (preferenceManager.getString(Constants.KEY_USER_ID)
                );
        documentReference.update(Constants.KEY_FCM_TOKEN,token)
                .addOnFailureListener(e -> showToast("Unable to update token"));
        preferenceManager.putString(Constants.KEY_FCM_TOKEN,token);
    }

    @Override
    public void onConversionClicked(CUser user) {
        Intent intent = new Intent(getApplicationContext(),chatScreenActivity.class);
        intent.putExtra("user",user);
        startActivity(intent);
    }
}