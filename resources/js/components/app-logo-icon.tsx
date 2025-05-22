import React from 'react';
import { ImgHTMLAttributes } from 'react';

export default function AppLogoIcon(props: ImgHTMLAttributes<HTMLImageElement>) {
    return (
        <img
            src="logooo.png"
            alt="App Logo"
            {...props}
            style={{ width: 'auto', height: '40px', ...props.style }}
        />
    );
}
