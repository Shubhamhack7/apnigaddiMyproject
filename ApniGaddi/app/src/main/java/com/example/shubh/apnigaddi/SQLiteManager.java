package com.example.shubh.apnigaddi;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.DatabaseUtils;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

public class SQLiteManager extends SQLiteOpenHelper {

    public final static String DATABASE_NAME = "User.db";
    public final static String USER_TABLE = "user";
    public final static int VERSION = 1;
    public final static String ID ="ID";
    public final static String UID ="UID";
    public final static String EMAIL ="EMAIL";
    public final static String PASSWORD ="PASSWORD";


    SQLiteDatabase db;


    public SQLiteManager(Context context) {
        super(context, DATABASE_NAME, null, VERSION);
        db=this.getWritableDatabase();
        Log.e("database","Database Created...");
    }

    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        sqLiteDatabase.execSQL("create table " + USER_TABLE + " ( " + ID + " INTEGER PRIMARY KEY AUTOINCREMENT, " + UID + " VARCHAR, " + EMAIL + " VARCHAR, " + PASSWORD + " VARCHAR);");

        Log.e("database","Table Created...");
    }

    @Override
    public void onUpgrade(SQLiteDatabase sqLiteDatabase, int i, int i1) {
        db.execSQL("DROP TABLE IF EXISTS " + USER_TABLE);
        Log.e("database","Table Dropped...");
        onCreate(db);
    }

    public void userLogin(String uid,String email,String pass) {
        ContentValues contentValues = new ContentValues();
        contentValues.put(UID,uid);
        contentValues.put(EMAIL,email);
        contentValues.put(PASSWORD,pass);
        db.insert(USER_TABLE, null, contentValues);
        db.close();
        Log.e("database","Record Inserted...");

    }

    public Cursor getuserlogin()
    {
        Cursor data = db.rawQuery("SELECT * FROM "+ USER_TABLE,null);
        Log.e("database","All record get Sucessfully..."+ DatabaseUtils.dumpCursorToString(data));
        return data;
    }
    public int gettablelogin()
    {
        Cursor data = db.rawQuery("SELECT * FROM "+ USER_TABLE ,null);

        Log.e("database","All record get Sucessfully..."+ data.getCount());
        return data.getCount();
    }

}
