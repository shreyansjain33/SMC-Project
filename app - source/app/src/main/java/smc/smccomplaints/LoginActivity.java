package smc.smccomplaints;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.backendless.Backendless;
import com.backendless.BackendlessUser;
import com.backendless.async.callback.AsyncCallback;
import com.backendless.exceptions.BackendlessFault;

public class LoginActivity extends AppCompatActivity {

    Button login;
    EditText email, password;
    SharedPreferences sharedpreferences;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        email = (EditText) findViewById(R.id.emailid);
        password = (EditText) findViewById(R.id.password);
        login = (Button) findViewById(R.id.login);
        sharedpreferences = getSharedPreferences(HomeActivity.MyPREFERENCES, Context.MODE_PRIVATE);

        login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                Backendless.UserService.login(email.getText().toString(), password.getText().toString(), new AsyncCallback<BackendlessUser>() {
                    public void handleResponse(BackendlessUser user) {
                        SharedPreferences.Editor editor = sharedpreferences.edit();
                        editor.putString(HomeActivity.objectId, user.getObjectId());
                        editor.apply();
                        HomeActivity.userToken = user.getObjectId();
                        startActivity(new Intent(getApplicationContext(), CameraActivity.class));
                        finish();
                    }

                    public void handleFault(BackendlessFault fault) {
                        // login failed, to get the error code call fault.getCode()
                        Toast.makeText(getApplicationContext(), fault.getMessage(), Toast.LENGTH_LONG).show();
                    }
                }, true);
            }
        });
    }
}
