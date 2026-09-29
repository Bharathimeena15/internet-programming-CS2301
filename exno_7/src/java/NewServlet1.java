import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;



import java.io.IOException;
import java.io.PrintWriter;

@WebServlet("/profile")
public class NewServlet1 extends HttpServlet {

@Override
protected void doPost(HttpServletRequest request,
                      HttpServletResponse response)
        throws ServletException, IOException {

    // Get values from hidden form fields
    String name = request.getParameter("name");
    String password = request.getParameter("password");

    response.setContentType("text/html");

    PrintWriter out = response.getWriter();

    out.println("<html>");
    out.println("<head><title>Profile</title></head>");
    out.println("<body>");

    out.println("<h2>Hidden Form Field Demonstration</h2>");

    out.println("<p>Name received: "
            + name + "</p>");

    out.println("<p>Password received: "
            + password + "</p>");

    out.println("<p>");
    out.println("The data was passed from LoginServlet ");
    out.println("to ProfileServlet using hidden form fields.");
    out.println("</p>");

    out.println("<br>");

    String statsURL = response.encodeURL("stats");

    out.println("<a href='" + statsURL + "'>");
    out.println("View Visitor Statistics");
    out.println("</a>");

    out.println("</body>");
    out.println("</html>");
}


}