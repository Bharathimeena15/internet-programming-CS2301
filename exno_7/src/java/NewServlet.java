import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;



import java.io.IOException;
import java.io.PrintWriter;

@WebServlet("/login")
public class NewServlet extends HttpServlet {

@Override
protected void doPost(HttpServletRequest request,
                      HttpServletResponse response)
        throws ServletException, IOException {

    String name = request.getParameter("name");
    String password = request.getParameter("password");

    // Create session
    HttpSession session = request.getSession();

    // Store information in session
    session.setAttribute("name", name);
    session.setAttribute("password", password);

    response.setContentType("text/html");

    PrintWriter out = response.getWriter();

    out.println("<html>");
    out.println("<head><title>Welcome</title></head>");
    out.println("<body>");

    out.println("<h2>Login Successful</h2>");

    out.println("<h3>Welcome, " + name + "!</h3>");

    out.println("<p>Session ID: "
            + session.getId() + "</p>");

    out.println("<hr>");

    out.println("<h3>Hidden Form Field Tracking</h3>");

    /*
     * The following values are passed to ProfileServlet
     * using hidden form fields.
     */
    out.println("<form action='profile' method='post'>");

    out.println("<input type='hidden' "
            + "name='name' value='" + name + "'>");

    out.println("<input type='hidden' "
            + "name='password' value='" + password + "'>");

    out.println("<input type='submit' "
            + "value='Continue Using Hidden Fields'>");

    out.println("</form>");

    out.println("<br>");

    /*
     * URL rewriting demonstration
     */
    String statsURL = response.encodeURL("stats");

    out.println("<h3>URL Rewriting</h3>");

    out.println("<a href='" + statsURL + "'>");
    out.println("View Unique Visitor Statistics");
    out.println("</a>");

    out.println("</body>");
    out.println("</html>");
}


}