import type { ImgHTMLAttributes } from 'react';

export default function AppLogoIcon(props: ImgHTMLAttributes<HTMLImageElement>) {
  return <img src="/logooo.svg" alt="App Logo" {...props} />;
}
