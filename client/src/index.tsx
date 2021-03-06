import React from "react";
import ReactDOM from "react-dom";
import "./assets/main.css";
import App from "./App";
import * as serviceWorker from "./serviceWorker";
import {
  createMuiTheme,
  responsiveFontSizes,
  ThemeProvider
} from "@material-ui/core/styles";
import ApolloClient from "apollo-boost";
import { ApolloProvider } from "@apollo/react-hooks";
import primary from "./theme/intentions/primary";
import secondary from "./theme/intentions/secondary";

require('velocity-animate');

const client = new ApolloClient({
  uri: "/graphql"
});

let theme = createMuiTheme({
  palette: {
    primary,
    secondary
  }
});
theme = responsiveFontSizes(theme);

ReactDOM.render(
  <ApolloProvider client={client}>
    <ThemeProvider theme={theme}>
      <App />
    </ThemeProvider>
  </ApolloProvider>,
  document.getElementById("root")
);

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
