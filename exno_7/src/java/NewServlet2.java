import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;


@WebServlet("/stats")
public class NewServlet2 extends HttpServlet {

@Override
protected void doGet(HttpServletRequest request,
                     HttpServletResponse response)
        throws ServletException, IOException {

    /*
     * Get the existing session.
     * If there is no session, create one.
     */
    HttpSession session = request.getSession();

    /*
     * Count only a new session.
     * Therefore, refreshing this page does not
     * increase the visitor count.
     */
    if (session.isNew()) {

        Integer count =
                (Integer) getServletContext()
                        .getAttribute("uniqueVisitors");

        if (count == null) {
            count = 0;
        }

        count++;

        getServletContext()
                .setAttribute("uniqueVisitors", count);
    }

    Integer visitors =
            (Integer) getServletContext()
                    .getAttribute("uniqueVisitors");

    if (visitors == null) {
        visitors = 0;
    }

    response.setContentType("text/html");

    PrintWriter out = response.getWriter();

    out.println("<html>");
    out.println("<head>");
    out.println("<title>Visitor Statistics</title>");
    out.println("</head>");

    out.println("<body>");

    out.println("<h2>Unique Visitor Statistics</h2>");

    out.println("<h3>");
    out.println("Number of Unique Visitors: " + visitors);
    out.println("</h3>");

    out.println("<p>Your Session ID: "
            + session.getId() + "</p>");

    out.println("<p>");
    out.println("The count represents unique sessions ");
    out.println("that have accessed this page.");
    out.println("</p>");

    out.println("<hr>");

    /*
     * URL rewriting
     */
    String encodedURL = response.encodeURL("stats");

    out.println("<a href='" + encodedURL + "'>");
    out.println("Refresh Statistics");
    out.println("</a>");

    out.println("</body>");
    out.println("</html>");
}


}