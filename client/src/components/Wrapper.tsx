import React from "react";
import { makeStyles } from "@material-ui/core";

const useStyles = makeStyles({
  wrapper: {
    display: "flex",
    flexDirection: (props : {direction? : "row" | "column"}) => props?.direction ?? "row"
  }
});
const Wrapper: React.FC<{ direction?: "row" | "column" }> = ({
  children,
  direction
}) => {
    const styles = useStyles({direction});
    return <div className={styles.wrapper}>{children}</div>;
};

export default Wrapper;
