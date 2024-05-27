import java.io.FileReader;
import java.util.Properties;

import java.io.IOException;
import java.io.FileNotFoundException;
import javax.mail.MessagingException;

import javax.mail.Session;
import javax.mail.Message;
import javax.mail.Transport;
import javax.mail.Authenticator;
import javax.mail.PasswordAuthentication;
import javax.mail.internet.MimeMessage;
import javax.mail.internet.InternetAddress;

public class MailSender {

	public static void main(String[] args) throws IOException, FileNotFoundException{
		
		// プロパティファイルから認証に使用するデータを取得
		Properties prop = new Properties();
		prop.load(new FileReader("/virtual/chofusai/public_html/app/items/src/setting/mail.properties"));
		
		// 送信元のGmailアドレス
		final String username = prop.getProperty("mailaddress");
		// Gmailのアカウントのアプリパスワード
		final String password = prop.getProperty("password");
		// SMTPサーバへの認証とメールセッションの作成 
		// ※メールセッション = メールの送信に関するパラメータや設定を保持
		Session session = Session.getInstance(prop, new Authenticator() {
			protected PasswordAuthentication getPasswordAuthentication() {
				return new PasswordAuthentication(username, password);
			}
		});
        
		try {
			// メール送信準備
			Message message = new MimeMessage(session);
			// 送信元の設定
			message.setFrom(new InternetAddress(username));
			// 送信先の設定
			message.setRecipients(Message.RecipientType.TO, InternetAddress.parse(args[0]));
			// 件名の設定
			message.setSubject("申請受理のお知らせ");
			// 本文の設定
			message.setText(args[1] + "申請の受付を完了しました。ユーザーIDとパスワードはこちらです。\nユーザーID：" + args[2] + "\nパスワード：" + args[3]);

			// メールの送信
			Transport.send(message);
			// 成功時のメッセージ
			System.out.println("Email sent successfully.");
		} catch (MessagingException e) {
			// 失敗時のメッセージ
			System.err.println("Email sent unsuccessfully ： " + e );
		}
	}
}
