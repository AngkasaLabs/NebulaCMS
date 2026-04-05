import { Head, router } from '@inertiajs/react';
import { FormEvent, useState } from 'react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

interface Role {
    id: number;
    name: string;
}

interface Props {
    roles: Role[];
}

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Users',
        href: route('admin.users.index'),
    },
    {
        title: 'Create'
    },
];

export default function Create({ roles }: Props) {
    const [values, setValues] = useState({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        role: '', // Single role as string
        bio: '',
        avatar: null as File | null,
        facebook_url: '',
        twitter_url: '',
        instagram_url: '',
        linkedin_url: '',
    });

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        // Convert role to array when submitting
        router.post('/users', {
            ...values,
            roles: [values.role], // Send as array
        });
    };

    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.files?.[0]) {
            setValues({ ...values, avatar: e.target.files[0] });
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create User" />

            <div className="p-4">
                <form onSubmit={handleSubmit}>
                    <div className="grid gap-4 md:grid-cols-2">
                        <Card>
                            <CardHeader>
                                <CardTitle>Basic Information</CardTitle>
                            </CardHeader>
                            <CardContent className="grid gap-4">
                                <div>
                                    <Label htmlFor="name">Name</Label>
                                    <Input
                                        id="name"
                                        type="text"
                                        value={values.name}
                                        onChange={(e) =>
                                            setValues({
                                                ...values,
                                                name: e.target.value,
                                            })
                                        }
                                    />
                                </div>
                                <div>
                                    <Label htmlFor="email">Email</Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        value={values.email}
                                        onChange={(e) =>
                                            setValues({
                                                ...values,
                                                email: e.target.value,
                                            })
                                        }
                                    />
                                </div>
                                <div>
                                    <Label htmlFor="password">Password</Label>
                                    <Input
                                        id="password"
                                        type="password"
                                        value={values.password}
                                        onChange={(e) =>
                                            setValues({
                                                ...values,
                                                password: e.target.value,
                                            })
                                        }
                                    />
                                </div>
                                <div>
                                    <Label htmlFor="password_confirmation">
                                        Confirm Password
                                    </Label>
                                    <Input
                                        id="password_confirmation"
                                        type="password"
                                        value={values.password_confirmation}
                                        onChange={(e) =>
                                            setValues({
                                                ...values,
                                                password_confirmation:
                                                    e.target.value,
                                            })
                                        }
                                    />
                                </div>
                                <div>
                                    <Label htmlFor="roles">Roles</Label>
                                    <Select
                                        defaultValue={values.role}
                                        onValueChange={(value) =>
                                            setValues({
                                                ...values,
                                                role: value,
                                            })
                                        }
                                    >
                                        <SelectTrigger className="w-full">
                                            <SelectValue placeholder="Select role" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            {roles.map((role) => (
                                                <SelectItem
                                                    key={role.id}
                                                    value={role.name}
                                                >
                                                    {role.name}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Profile Information</CardTitle>
                            </CardHeader>
                            <CardContent className="grid gap-4">
                                <div>
                                    <Label htmlFor="avatar">Avatar</Label>
                                    <Input
                                        id="avatar"
                                        type="file"
                                        accept="image/*"
                                        onChange={handleFileChange}
                                    />
                                </div>
                                <div>
                                    <Label htmlFor="bio">Bio</Label>
                                    <Textarea
                                        id="bio"
                                        value={values.bio}
                                        onChange={(e) =>
                                            setValues({
                                                ...values,
                                                bio: e.target.value,
                                            })
                                        }
                                    />
                                </div>
                                <div>
                                    <Label htmlFor="facebook_url">
                                        Facebook URL
                                    </Label>
                                    <Input
                                        id="facebook_url"
                                        type="url"
                                        value={values.facebook_url}
                                        onChange={(e) =>
                                            setValues({
                                                ...values,
                                                facebook_url: e.target.value,
                                            })
                                        }
                                    />
                                </div>
                                <div>
                                    <Label htmlFor="twitter_url">
                                        Twitter URL
                                    </Label>
                                    <Input
                                        id="twitter_url"
                                        type="url"
                                        value={values.twitter_url}
                                        onChange={(e) =>
                                            setValues({
                                                ...values,
                                                twitter_url: e.target.value,
                                            })
                                        }
                                    />
                                </div>
                                <div>
                                    <Label htmlFor="instagram_url">
                                        Instagram URL
                                    </Label>
                                    <Input
                                        id="instagram_url"
                                        type="url"
                                        value={values.instagram_url}
                                        onChange={(e) =>
                                            setValues({
                                                ...values,
                                                instagram_url: e.target.value,
                                            })
                                        }
                                    />
                                </div>
                                <div>
                                    <Label htmlFor="linkedin_url">
                                        LinkedIn URL
                                    </Label>
                                    <Input
                                        id="linkedin_url"
                                        type="url"
                                        value={values.linkedin_url}
                                        onChange={(e) =>
                                            setValues({
                                                ...values,
                                                linkedin_url: e.target.value,
                                            })
                                        }
                                    />
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    <div className="mt-4 flex justify-end">
                        <Button type="submit">Create User</Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
