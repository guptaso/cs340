# cs340
http://web.engr.oregonstate.edu/~guptaso/cs340_finalproject/


~~1. You must use MySQL or MariaDB as the database backend for your application. You may use the COE-provided MariaDB database (recommended) or some other MySQL database that you will be able to programmatically query from the server in which your web application is running.~~

~~2. Your web application must be reachable by HTTP from the public Internet (or by a VPN into campus), so that the instructor and TAs will be able to access your application to test it out (which is a part of the evaluation process for grading your project). If you are hosting your web application on your own webserver, HTTPS is not required (though it is absolutely essential in the real world). NOTE: if you are hosting your application on one of the COE servers, that should satisfy this requirement since we can access your application even from off-campus by using the campus VPN.~~

3. Your database should have at least four tables and at least four relationships (codified in appropriate foreign key constraints with appropriate triggered actions for DELETE and UPDATE). Tables should have attributes appropriate to your miniworld with appropriate constraints (NOT NULL, set values, etc.). 

~~4. Your application should employ SQL queries that you have designed and implemented; you are not permitted to use queries that are autogenerated by an Object-Relational Mapping (ORM) framework.~~

5. For whatever is the main type of "thing" that you are tracking in your miniworld, your web application should provide full CRUD (Create, Read, Update, Delete) functionality. Your application should accept data using HTML forms and display data in some kind of tabular format, listbox format, etc. Just having a text-box for the user to enter SQL queries is not acceptable (and worrisome from a security standopoint if this was a real-world system). Your web application should have at least two different pages or views.

6. Your application's front-end (HTML/CSS/JS) must be compatible with current versions of Chrome and Firefox; do not intentionally use browser features that break compatibility, as much as you might prefer one rendering engine over another.

~~7. You are encouraged to use PHP/HTML for your assignment, but Node.js or other programming frameworks are certainly allowed. If you do not use PHP or Node.js, you will have to figure out how to host your web application.~~

~~8. Use of DHTML is not required; you are welcome to use a simpler non-dynamic HTML-based UI paradigm if you wish, and you will not be penalized for that design choice as long as your application is functional. You are of course free to use DHTML and to make extensive use of front-end JavaScript, but you are on your own to troubleshoot it.~~

~~9. Your project will be tested and graded by accessing your web application using a desktop computer web browser, not a mobile device, and accessibility (while extremely important in the real world as codified in federal law) will not be a factor in determining your project grade. Moreover, neither dynamic layout nor responsive website design are required. There are no extra points for the aesthetic quality of your project website—it just needs to be functional. Thus, while you are free to choose to use a modern front-end framework if you wish, you are on your own to troubleshoot it.~~

10. Each of the tables in your database should be pre-populated with some data (i.e., it should not be entirely empty when the TAs and instructor test it out).

11. You are welcome to have support for user-specific logins on your website (though this is not required), but please see the above requirement – there needs to be some data in the database when the TA or instructor log in. Furthermore, if you have user authentication on your site, you are required to provide the TAs and the instructor with a username and password (in the URL.txt file; see Final Project Submission) so that they may log into your application without having to complete the signup page.

~~12. Internationalization and Unicode support are extremely important in the real-world, but your web application should use U.S. English and it is not a requirement to support Unicode input. We cannot grade a web application if the content is in a language (or even character set) that we cannot read or do not understand.~~

~~13. Strict W3C standards compliance, while laudable, is not a requirement for this project; but see requirement (6) above. ~~

~~14. While obfuscation of front-end code is sometimes used in the real world, source code that you turn in for this project should not be obfuscated; readability is essential in the evaluation process.~~

15. Your web application should render in a "stock" version of Chrome and Firefox. Use of Adobe Flash, Java applet, JNLP, or any in-browser runtime framework that would require installation of a non-standard browser plugin/extension is not allowed.

16. Your application should make some effort to defend against a SQL injection attack, as described in the SQL injection section of the PHP manual (Links to an external site.)Links to an external site.. Acceptable countermeasures would be either to manually (or using a library function) check input data for invalid characters or to use prepared statements and parameterized queries such as through the PHP Data Objects (PDO) class (Links to an external site.)Links to an external site..

17. Your application source code (the application logic code, not the DDL SQL code) should be commented; see Code commenting guidelines.

18. The data that you have pre-populated in your database tables should be visible in the UI of your web application; in other words, the application should not be "empty" when the instructor or TA first uses it.
