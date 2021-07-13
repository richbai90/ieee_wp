import React from "react";
import { RouteComponentProps } from "@reach/router";
import Header from "../components/Header";
import Wrapper from "../components/Wrapper";
import Carousel from "../components/Carousel";

const Home: React.FC<RouteComponentProps> = () => {
  return (
    <Wrapper direction="column">
      <Header />
      <Carousel />
    </Wrapper>
  );
};

export default Home;
