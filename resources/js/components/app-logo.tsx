import AppLogoIcon from './app-logo-icon';

export default function AppLogo() {
    return (
        <div className="flex items-center space-x-2">
            <div className="bg-transparent h-20 w-20 flex items-center justify-center rounded-md shadow-none filter-none">
                <AppLogoIcon className="h-16 w-16 fill-current text-black dark:text-white" />
            </div>
            <div className="grid text-left text-base">
                <span className="mb-0.5 truncate font-semibold leading-none text-black dark:text-white">
                    Nanyanya
                </span>
            </div>
        </div>
    );
}
