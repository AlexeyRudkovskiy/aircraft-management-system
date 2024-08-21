import {Link} from "react-router-dom";

export default ({ children, url }) => {
    return <Link to={url} className="px-6 py-4 block hover:bg-gray-100 text-gray-600 hover:text-gray-700">{children}</Link>;
}
