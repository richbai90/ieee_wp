import React from "react";
import {
  AppBar,
  Toolbar,
  Typography,
  makeStyles,
  createStyles,
  Fade,
  Button
} from "@material-ui/core";
import { useQuery } from "@apollo/react-hooks";
import { gql } from "apollo-boost";
import { ReactComponent as Logo } from "../assets/IEEE_logo.svg";

interface Page {
  id: string;
  title: string;
  slug: string;
  uri: string;
}

const useStyles = makeStyles(
  createStyles({
    container: {
      display: "flex",
      flex: "1 1 auto"
    },
    pageLinks: {
      display: "flex",
      listStyle: "none",
      marginLeft: "auto",
      '& li': {
        height: '100%'
      },
      '& button': {
        height: '100%',
        color: '#fff'
      }
    },
    logo: {
      display: "flex"
    },
    separator: {
      width: "1em",
      borderColor: "#fff",
      borderRightWidth: "5px",
      borderRightStyle: "solid"
    },
    title: {
      padding: "0 .5em",
      textAlign: "center",
      alignSelf: "center"
    }
  })
);

const titleQuery = gql`
  {
    allSettings {
      generalSettingsTitle
    }
    pages {
      nodes {
        id
        title(format: RENDERED)
        slug
        uri
      }
    }
  }
`;

const pages = (pages: Page[]) =>
  pages.map(page => (
    <li>
      <Button key={page.id}>
        {page.title}
      </Button>
    </li>
  ));
const Header: React.FC = () => {
  const { logo, separator, title, container, pageLinks } = useStyles();
  const { data, loading, error } = useQuery(titleQuery);
  return (
    <AppBar position="static">
      <Toolbar>
        <Fade in={!loading && !error}>
          <div className={container}>
            <div className={logo}>
              <Logo />
              <div className={separator} />
              <Typography variant="h5" className={title}>
                {data?.allSettings?.generalSettingsTitle ?? ""}
              </Typography>
            </div>
            <ul className={pageLinks}>{pages(data?.pages?.nodes ?? [])}</ul>
          </div>
        </Fade>
      </Toolbar>
    </AppBar>
  );
};

export default Header;
