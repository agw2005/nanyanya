import AuthLayoutTemplate from '@/layouts/auth/auth-simple-layout';

interface AuthLayoutProps {
  children: React.ReactNode;
  title: string;
  description: string;
  logoClassName?: string;
}

export default function AuthLayout({ children, title, description, logoClassName }: AuthLayoutProps) {
  return (
    <AuthLayoutTemplate title={title} description={description} logoClassName={logoClassName}>
      {children}
    </AuthLayoutTemplate>
  );
}
