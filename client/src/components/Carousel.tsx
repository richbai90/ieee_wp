import React, { useEffect, useState, useRef } from "react";
import { Container, makeStyles, Theme, Slide } from "@material-ui/core";
import LinkedList from "../helpers/LinkedList";
import { VelocityComponent } from "velocity-react";

const useStyles = makeStyles((theme: Theme) => ({
  carousel: {
    height: "40vh",
    background: theme.palette.background.default,
    display: "flex",
    overflow: "hidden",
    padding: 0,
    position: "relative"
  },
  image: {
    minWidth: "100%",
    height: "auto",
    objectFit: "fill"
  },
  renderedImage: {
    transition: "transform 2s ease-in-out",
    transform: (props: { transition: boolean }) =>
      props.transition ? "translateX(-7000px)" : "none"
  }
}));
const Carousel = () => {
  const [images, setImages] = useState<LinkedList<string>>();
  const [renderedImages, setRenderedImages] = useState<[string, string]>([
    "",
    ""
  ]);
  const [transition, setTransition] = useState<boolean>(false);
  useEffect(() => {
    const getImages = async () => {
      const imageResponse = await fetch("https://api.unsplash.com/photos/", {
        headers: {
          Authorization:
            "Client-ID 86b159bd11782423050994647531171582ede1de67186634db1e89432644786b",
          "Content-Type": "application/json"
        }
      });
      const json = await imageResponse.json();
      setImages(new LinkedList(json.map((i: any) => i.urls?.regular ?? "")));
    };

    getImages();
  }, []);
  const interval = useRef(-1);
  useEffect(() => {
    if (images?.size()) {
      if (!renderedImages[0]) {
        setRenderedImages([images?.next() ?? "", images?.next() ?? ""]);
      }
      if (interval.current === -1) {
        interval.current = window.setInterval(() => {
          setTransition(true);
          console.log('oooooh!!')
          setTimeout(() => {
            setTransition(false);
            // setRenderedImages([
            //   renderedImages[1] || images.next(),
            //   images.next()
            // ]);
          }, 2000);
        }, 7000);
      }
    }
  }, [images, renderedImages, transition]);
  const styles = useStyles({ transition });
  return (
    <Slide direction="down" timeout={700} in={true}>
      <Container className={styles.carousel}>
        {renderedImages.map((img, i) => (
          <VelocityComponent
            animation={{
              transform: transition ? "translateX(-7000px)" : "none"
            }}
            duration={7000}
          >
            <img className={styles.image} alt="" src={img} />
          </VelocityComponent>
        ))}
      </Container>
    </Slide>
  );
};

export default Carousel;
